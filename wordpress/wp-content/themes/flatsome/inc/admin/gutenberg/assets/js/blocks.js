/* global wp */
;(function () {
  var el = wp.element.createElement
  var useDispatch = wp.data.useDispatch
  var registerBlockType = wp.blocks.registerBlockType
  var useBlockProps = wp.blockEditor.useBlockProps || function (props) { return props; }

  function FlatsomeIcon (props) {
    return el(
      'svg',
      {
        width: props.width || 24,
        height: props.height || 24,
        viewBox: '0 0 33 32',
        fill: 'none',
        xmlns: 'http://www.w3.org/2000/svg'
      },
      [
        el('path', { key: 0, fill: 'currentColor', d: 'M15.9433 4.47626L18.474 7.00169L7.01624 18.4357L4.48556 15.9103L15.9433 4.47626ZM15.9433 0L0 15.9103L7.01624 22.912L22.9596 7.00169L15.9433 0Z' }),
        el('path', { key: 1, fill: 'currentColor', d: 'M16.128 22.83L18.4798 25.1769L16.128 27.5239L13.7761 25.1769L16.128 22.83ZM16.128 18.3537L9.29039 25.1766L16.128 32L22.9655 25.1766L16.128 18.3532V18.3537Z' }),
        el('path', { key: 2, fill: 'currentColor', fillOpacity: '0.6', d: 'M25.229 13.7475L27.5808 16.0945L25.229 18.4414L22.8775 16.0946L25.2293 13.7477L25.229 13.7475ZM25.2293 9.27141L18.3914 16.0946L25.229 22.918L32.0666 16.0946L25.229 9.27124L25.2293 9.27141Z' })
      ]
    )
  }

  function gotoUxBuilder () {
    if (window.flatsome_gutenberg) {
      window.top.location.href = window.flatsome_gutenberg.edit_button.url
    }
  }

  function Placeholder () {
    var editor = useDispatch('core/editor')
    var blockProps = useBlockProps()

    return el('div', blockProps, [
      el(
        wp.components.Placeholder,
        {
          key: 'placeholder',
          icon: el(FlatsomeIcon, { width: 21, height: 21 }),
          label: 'UX Builder content',
          instructions: 'This content can only be edited in UX Builder.'
        },
        el(
          wp.components.Button,
          {
            variant: 'secondary',
            onFocus: function (e) {
              e.stopPropagation()
            },
            onClick: function () {
              editor.savePost().then(gotoUxBuilder)
            }
          },
          'Edit with UX Builder'
        )
      )
    ])
  }

  function SaveRawHTML (props) {
    return el(wp.element.RawHTML, {}, props.attributes.content)
  }

  registerBlockType('flatsome/uxbuilder', {
    icon: FlatsomeIcon,
    edit: Placeholder,
    save: SaveRawHTML
  })
}())
