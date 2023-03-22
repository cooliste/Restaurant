<template>
  <div v-if="supplier">
    <div class="table-responsive mb16">
      <div class="ivu-table-wrapper ivu-table-wrapper-with-border">
        <div class="ivu-table ivu-table-default ivu-table-border">
          <div class="ivu-table-body">
            <table cellspacing="0" cellpadding="0" border="0" style="width:100%;min-width:300px">
              <tbody class="ivu-table-tbody">
                <tr class="ivu-table-row">
                  <td style="width:40%;min-width:100px">
                    <div class="ivu-table-cell">
                      <div class="ivu-table-cell-slot">{{ $t('name') }}</div>
                    </div>
                  </td>
                  <td style="width:60%;min-width:200px">
                    <div class="ivu-table-cell">
                      <strong>{{ supplier.name }}</strong> <span v-if="supplier.company">({{ supplier.company }})</span>
                    </div>
                  </td>
                </tr>
                <tr class="ivu-table-row">
                  <td style="width:40%;min-width:100px">
                    <div class="ivu-table-cell">
                      <div class="ivu-table-cell-slot">{{ $t('phone') }}</div>
                    </div>
                  </td>
                  <td style="width:60%;min-width:200px">
                    <div class="ivu-table-cell">
                      <strong>{{ supplier.phone }}</strong> <span v-if="supplier.email">({{ supplier.email }})</span>
                    </div>
                  </td>
                </tr>
                <tr class="ivu-table-row" v-if="supplier.journal && supplier.journal.balance">
                  <td style="width:40%;min-width:100px">
                    <div class="ivu-table-cell">
                      <div class="ivu-table-cell-slot">{{ supplier.journal.balance.amount > 0 ? $t('due') : $t('deposit') }}</div>
                    </div>
                  </td>
                  <td style="width:60%;min-width:200px">
                    <div class="ivu-table-cell">
                      {{ supplier.journal.balance.amount > 0 ? $t('due') : $t('advance') }}:
                      <strong>{{
                        supplier.journal
                          ? formatJournalBalance(
                              supplier.journal.balance.amount > 0 ? supplier.journal.balance.amount : 0 - supplier.journal.balance.amount,
                              $store.getters.settings.decimals
                            )
                          : ''
                      }}</strong>
                    </div>
                  </td>
                </tr>
                <tr class="ivu-table-row">
                  <td style="width:40%;min-width:100px">
                    <div class="ivu-table-cell">
                      <div class="ivu-table-cell-slot">{{ $t('address') }}</div>
                    </div>
                  </td>
                  <td style="width:60%;min-width:200px">
                    <div class="ivu-table-cell">
                      {{ `${supplier.address || ''} ${supplier.state_name || ''} ${supplier.country_name || ''}` }}
                    </div>
                  </td>
                </tr>
                <tr class="ivu-table-row" v-if="supplier.extra_attributes && supplier.extra_attributes.length">
                  <td style="width:40%;min-width:100px">
                    <div class="ivu-table-cell">
                      <div class="ivu-table-cell-slot">{{ $tc('field', 2) }}</div>
                    </div>
                  </td>
                  <td style="width:60%;min-width:200px">
                    <div class="ivu-table-cell">
                      {{
                        Object.entries(supplier.extra_attributes)
                          .map(e => e.join(': '))
                          .join(', ')
                      }}
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    <div class="text-center">
      <Button v-if="addUserFn" @click="addUserFn(supplier)">{{ $t('add_x', { x: $tc('user') }) }}</Button>
      <Button v-if="listUsersFn" @click="listUsersFn(supplier)">{{ $t('list_x', { x: $tc('user', 2) }) }}</Button>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    supplier: {
      required: true,
    },
    addUserFn: {
      type: Function,
      required: false,
    },
    listUsersFn: {
      type: Function,
      required: false,
    },
  },
  // watch: {
  //   'supplier.id': function(v, o) {
  //     this.getStock();
  //   },
  // },
  // data() {
  //   return {
  //     stock: [],
  //   };
  // },
  // methods: {
  //   getStock() {
  //     this.$http.get('app/stock/' + this.supplier.id).then(res => (this.stock = res.data));
  //   },
  // },
};
</script>
