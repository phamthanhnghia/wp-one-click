jQuery('.composite_data').on('wc-composite-initializing', function (event, composite) {
  composite.actions.add_action('component_scripts_initialized', function () {
    jQuery('.quantity').addQty()
    Flatsome.attach('lazy-load-images', jQuery('.composite_component'))
  }, 100)
})
