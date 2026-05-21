/* global wp */
wp.domReady(function () {
  var el = wp.element.createElement
  var SelectControl = wp.components.SelectControl
  var PluginDocumentSettingPanel = wp.editPost.PluginDocumentSettingPanel

  wp.plugins.registerPlugin('flatsome-page-layout', {
    render: function () {
      var dispatch = wp.data.useDispatch('core/editor')
      var selected = wp.data.useSelect(function (select) {
        var store = select('core/editor')
        var meta = store.getEditedPostAttribute('meta') || {}
        return {
          postType: store.getCurrentPostType(),
          footer: meta._footer || 'normal'
        }
      }, [])

      if (selected.postType !== 'page') {
        return null
      }

      return el(
        PluginDocumentSettingPanel,
        {
          name: 'flatsome-page-layout',
          title: 'Page Layout'
        },
        el(SelectControl, {
          label: 'Page Footer',
          value: selected.footer,
          options: [
            { label: 'Normal', value: 'normal' },
            { label: 'Simple', value: 'simple' },
            { label: 'Custom', value: 'custom' },
            { label: 'Transparent', value: 'transparent' },
            { label: 'Hide', value: 'disabled' }
          ],
          onChange: function (value) {
            dispatch.editPost({ meta: { _footer: value } })
          }
        }))
    }
  })
})
