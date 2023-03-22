<template>
  <Card :dis-hover="true">
    <p slot="title">{{ $t('update') }} {{ $tc('company') }}</p>
    <router-link to="/" slot="extra">
      <Icon type="ios-grid-outline" />
      {{ $t('dashboard') }}
    </router-link>
    <div>
      <Form ref="company" :model="form" :rules="rules" :label-width="150" class="form-responsive">
        <Row :gutter="16">
          <Col :sm="24" :md="24" :lg="24">
            <Loading v-if="loading" />
            <Alert type="error" show-icon class="mb26" v-if="errors.message">
              <div v-html="errors.message"></div>
            </Alert>
            <Row :gutter="16">
              <Col :sm="24" :md="12" :lg="12">
                <FormItem :label="$t('name')" prop="name" :error="errors.form.name | a2s">
                  <Input v-model="form.name" />
                </FormItem>
              </Col>
              <Col :sm="24" :md="12" :lg="12">
                <FormItem :label="$tc('company')" prop="company" :error="errors.form.company | a2s">
                  <Input v-model="form.company" />
                </FormItem>
              </Col>
              <Col :sm="24" :md="12" :lg="12">
                <FormItem :label="$t('phone')" prop="phone" :error="errors.form.phone | a2s">
                  <Input v-model="form.phone" />
                </FormItem>
              </Col>
              <Col :sm="24" :md="12" :lg="12">
                <FormItem :label="$t('email')" prop="email" :error="errors.form.email | a2s">
                  <Input v-model="form.email" />
                </FormItem>
              </Col>
              <Col :sm="24" :md="12" :lg="12">
                <FormItem :label="$t('house_no')" prop="house_no" :error="errors.form.house_no | a2s">
                  <Input v-model="form.house_no" />
                </FormItem>
              </Col>
              <Col :sm="24" :md="12" :lg="12">
                <FormItem :label="$t('street_no')" prop="street_no" :error="errors.form.street_no | a2s">
                  <Input v-model="form.street_no" />
                </FormItem>
              </Col>
              <Col :sm="24" :md="24" :lg="24">
                <FormItem :label="$t('address')" prop="address" :error="errors.form.address | a2s">
                  <Input v-model="form.address" />
                </FormItem>
              </Col>
              <Col :sm="24" :md="12" :lg="12">
                <FormItem :label="$t('city')" prop="city" :error="errors.form.city | a2s">
                  <Input v-model="form.city" />
                </FormItem>
              </Col>
              <Col :sm="24" :md="12" :lg="12">
                <FormItem :label="$t('postal_code')" prop="postal_code" :error="errors.form.postal_code | a2s">
                  <Input v-model="form.postal_code" />
                </FormItem>
              </Col>
              <Col :sm="24" :md="12" :lg="12">
                <FormItem :label="$tc('country')" prop="country" :error="errors.form.country | a2s">
                  <Select v-model="form.country" placeholder filterable @on-change="countryChange">
                    <Option v-for="(option, index) in countries" :value="option.value" :key="index">{{ option.label }}</Option>
                  </Select>
                </FormItem>
              </Col>
              <Col :sm="24" :md="12" :lg="12">
                <FormItem :label="$tc('state')" prop="state" :error="errors.form.state | a2s">
                  <Select v-model="form.state" placeholder filterable :loading="searching">
                    <Option v-for="(option, index) in states" :value="option.value" :key="index">{{ option.label }}</Option>
                  </Select>
                </FormItem>
              </Col>
            </Row>

            <form-custom-fields v-model="form" :attributes="attributes" @update="updateCF" />

            <FormItem>
              <Button type="primary" :loading="saving" :disabled="saving" @click="handleSubmit()">
                <span v-if="!saving">{{ $t('submit') }}</span>
                <span v-else>{{ $t('saving') }}...</span>
              </Button>
            </FormItem>
          </Col>
        </Row>
      </Form>
    </div>
  </Card>
</template>

<script>
import Form from '@mpsjs/mixins/Form';
const formatRes = (data, vm) => {
  if (data.attributes) {
    vm.attributes = data.attributes;
    delete data.attributes;
  }
  data.extra_attributes = vm.formatAttributes(vm.attributes, data.extra_attributes);
  vm.form = { ...data, ...data.extra_attributes };
  return vm.form;
};
export default {
  data() {
    return {
      countries: [],
      saving: false,
      attributes: [],
      loading: false,
      searching: false,
      errors: { message: '', form: {} },
      states: [{ value: '', label: this.$t('select_country') }],
      form: {
        id: '',
        name: '',
        email: '',
        phone: '',
        state: '',
        number: '',
        footer: '',
        address: '',
        country: '',
      },
      rules: {
        name: [
          {
            required: true,
            trigger: 'blur',
            message: this.$t('field_is_required', { field: this.$t('name') }),
          },
        ],
        phone: [
          {
            required: false,
            trigger: 'blur',
            message: this.$t('field_is_required', { field: this.$t('phone') }),
          },
        ],
        email: [
          {
            required: false,
            trigger: 'blur',
            message: this.$t('field_is_required', { field: this.$t('email') }),
          },
        ],
        address: [
          {
            required: false,
            trigger: 'blur',
            message: this.$t('field_is_required', { field: this.$t('address') }),
          },
        ],
        country: [
          {
            trigger: 'change',
            required: this.$store.getters.require_country,
            message: this.$t('field_is_required', { field: this.$t('country') }),
          },
        ],
        state: [
          {
            trigger: 'change',
            required: this.$store.getters.require_country,
            message: this.$t('field_is_required', { field: this.$t('state') }),
          },
        ],
      },
    };
  },
  created() {
    this.$http.get('app/countries').then(({ data }) => (this.countries = data));
    if (this.$store.state.user) {
      if (this.$store.state.user.customer_id || this.$store.state.user.supplier_id) {
        this.$http
          .get(`app/user/company`)
          .then(res => {
            this.form = formatRes(res.data, this);
            if (this.form.country) {
              this.getStates(this.form.country, this.form.state);
            }
          })
          .finally(() => (this.loading = false));
      } else {
        this.$router.push('/');
      }
    } else {
      this.$router.push('/');
    }
  },
  methods: {
    handleSubmit() {
      this.$refs.company.validate(valid => {
        if (valid) {
          this.saving = true;
          this.$http
            .post(`app/user/company`, this.form)
            .then(res => {
              if (res.data.success) {
                this.$Notice.success({ title: this.$t('updated'), desc: this.$t('record_updated') });
              }
            })
            .finally(() => (this.saving = false));
        } else {
          this.$Notice.error({ title: this.$t('invalid_form'), desc: this.$t('invalid_form_error'), duration: 10 });
        }
      });
    },
    countryChange(code, state = '') {
      if (code) {
        this.searching = true;
        this.getStates(code, state);
        this.form.state = '';
      } else {
        this.form.state = '';
        this.form.country = '';
        this.states = [{ value: '', label: this.$t('select_country') }];
      }
    },
    getStates(country, selected) {
      this.$http
        .get('app/states', { params: { country } })
        .then(res => {
          this.states = res.data;
          if (selected) {
            this.form.state = this.states.find(state => state.value == selected).value;
          }
          this.searching = false;
        })
        .catch(err => this.$event.fire('appError', err.response));
    },
    updateCF(field, value) {
      this.form[field] = value;
      setTimeout(() => {
        this.$refs[model].validateField(field);
      }, 1000);
    },
  },
};
</script>
