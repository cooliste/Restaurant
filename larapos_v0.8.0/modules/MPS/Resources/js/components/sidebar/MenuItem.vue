<template>
  <Submenu :name="`${parentName}`">
    <template slot="title">
      <Icon :type="parentItem.icon || ''" />
      <span>{{ showTitle(parentItem) }}</span>
    </template>
    <template v-for="(item, ii) in children">
      <template v-if="item.children && item.children.length === 1">
        <side-menu-item v-if="showChildren(item)" :key="`m-${item.name || ii + 1}`" :parent-item="item"></side-menu-item>
        <menu-item v-else :name="getNameOrHref(item, true)" :key="`menu-${item.children[0].name || ii + 1}`">
          <Icon :type="item.children[0].icon || ''" />
          <span>{{ showTitle(item.children[0]) }}</span>
        </menu-item>
      </template>
      <template v-else>
        <side-menu-item v-if="showChildren(item)" :key="`m-${item.name || ii + 1}`" :parent-item="item"></side-menu-item>
        <menu-item v-else :name="getNameOrHref(item)" :key="`menu-${item.name || ii + 1}`">
          <Icon :type="item.icon || ''" />
          <span>{{ showTitle(item) }}</span>
        </menu-item>
      </template>
    </template>
  </Submenu>
</template>
<script>
import mixin from './mixins/mixin';
import itemMixin from './mixins/item-mixin';
export default {
  name: 'SideMenuItem',
  mixins: [mixin, itemMixin],
};
</script>
