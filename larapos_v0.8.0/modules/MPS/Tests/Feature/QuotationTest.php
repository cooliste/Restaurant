<?php

namespace Modules\MPS\Tests\Feature;

use Modules\MPS\Models\Tax;
use Modules\MPS\Models\Item;
use Modules\MPS\Models\Unit;
use Modules\MPS\Models\Brand;
use Modules\MPS\Models\Account;
use Modules\MPS\Models\Category;
use Modules\MPS\Models\Customer;
use Modules\MPS\Models\Location;
use Modules\MPS\Models\Quotation;
use Modules\MPS\Tests\MPSTestCase;
use Modules\MPS\Models\QuotationItem;

class QuotationTest extends MPSTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->user    = $this->createUser('super');
        $this->unit    = factory(Unit::class)->create();
        $this->brand   = factory(Brand::class)->create();
        $this->account = factory(Account::class)->create();
        $category      = factory(Category::class)->create();
        $this->route   = url(module('route')) . '/app/quotations/';
        factory('Modules\MPS\Models\Setting')->create(['mps_key' => 'stock', 'mps_value' => '1']);
        $locations = factory(Location::class, 2)->create(['account_id' => $this->account->id]);

        $taxes[]         = factory(Tax::class)->create(['name' => 'CGST @ 9%', 'code' => 'cgst@9', 'rate' => 9, 'compound' => false, 'state' => true, 'same' => true])->toArray()['id'];
        $taxes[]         = factory(Tax::class)->create(['name' => 'SGST @ 9%', 'code' => 'sgst@9', 'rate' => 9, 'compound' => false, 'state' => true, 'same' => true])->toArray()['id'];
        $taxes[]         = factory(Tax::class)->create(['name' => 'IGST @ 18%', 'code' => 'igst@18', 'rate' => 18, 'compound' => false, 'recoverable' => true, 'state' => true, 'same' => false])->toArray()['id'];
        $this->locations = $locations;
        $this->items     = factory(Item::class, 5)->create()->each(function ($item) use ($category, $locations, $taxes) {
            $item->taxes()->sync($taxes);
            $item->categories()->sync($category->id);
            foreach ($this->locations as $location) {
                session(['location_id' => $location->id]);
                $item->stock()->create(['quantity' => 20]);
            }
        });
    }

    public function testMPSCanCreatAndUpdateQuotation()
    {
        $location = $this->locations->first();
        session(['location_id' => $location->id]);
        $customer       = factory(Customer::class)->create(['user_id' => $this->user->id]);
        $new_quotation1 = factory(Quotation::class)->make([
            'customer_id' => $customer->id,
            'date'        => now()->format('Y-m-d'),
        ])->toArray();
        $new_quotation1['items'] = $this->items->random(2)->map(function ($item) use ($location, $customer) {
            $applicable_taxes = $item->taxes->filter(function ($tax) use ($location, $customer) {
                if ($tax->state) {
                    $check = $customer->state == $location->state;
                    return $tax->same ? $check : !$check;
                }
                return true;
            })->pluck('id')->all();
            return [
                'id'              => $item->id,
                'name'            => $item->name,
                'code'            => $item->code,
                'cost'            => $item->cost,
                'price'           => $item->price,
                'quantity'        => mt_rand(2, 5),
                'item_id'         => $item->id,
                'batch_no'        => 'bn123',
                'net_cost'        => $item->net_cost,
                'net_price'       => $item->net_price,
                'unit_cost'       => $item->unit_cost,
                'unit_price'      => $item->unit_price,
                'taxes'           => $applicable_taxes,
                'allTaxes'        => $item->taxes->pluck('id')->all(),
                'categories'      => $item->categories[0]->id,
                'selected'        => [],
                'discount_amount' => null,
                'discount'        => null,
                'promotions'      => null,
                'expiry_date'     => now()->format('Y-m-d'),
            ];
        })->toArray();

        // insert
        $response = $this->actingAs($this->user)->ajax()->post($this->route, $new_quotation1);
        $response->assertOk();

        // check
        $update    = $new_quotation1;
        $quotation = Quotation::with('items')->find($response['data']['id']);
        foreach ($quotation->items as $item) {
            $this->assertEquals(20, $item->stock()->first()->quantity);
        }

        // update
        $update['date'] = now()->subDays(2)->format('Y-m-d');
        $this->actingAs($this->user)->ajax()->put($this->route . $quotation->id, $update)->assertOk();

        $quotation = $quotation->refresh();
        $this->assertEquals($update['date'], $quotation->date->toDateString());
        foreach ($quotation->items as $item) {
            $item->refresh();
            $this->assertEquals(20, $item->stock()->first()->quantity);
        }

        // delete
        $this->actingAs($this->user)->ajax()->delete($this->route . $quotation->id)->assertOk();
        $this->assertModelMissing($quotation);
        $this->assertEquals(0, QuotationItem::count());
        $items = Item::with('stock')->get();
        foreach ($items as $item) {
            $this->assertEquals(20, $item->stock->where('location_id', $location->id)->first()->quantity);
        }
    }

    public function testMPSQuotationValidation()
    {
        $response = $this->actingAs($this->user)->ajax()->post($this->route, []);
        $response->assertStatus(422);
        $response->assertJsonStructure(['message', 'errors']);
        $response->assertJsonValidationErrors(['date', 'customer_id', 'items']);

        $response2 = $this->actingAs($this->user)->ajax()->post($this->route, ['items' => [['id' => 'test']]]);
        $response2->assertStatus(422);
        $response2->assertJsonStructure(['message', 'errors']);
        $response2->assertJsonValidationErrors(['date', 'customer_id', 'items.0.code', 'items.0.name', 'items.0.price', 'items.0.quantity']);
    }
}
