jQuery(function ($) {
	const $resetButton = jQuery('#flatsome-customizer-reset')
	const $clearTypographyCache = jQuery(
		'#flatsome-customizer-clear-typography-cache'
	)

	$resetButton.on('click', function (event) {
		event.preventDefault()

		var data = {
			wp_customize: 'on',
			action: 'customizer_reset',
			nonce: _FlatsomeCustomizerReset.nonce.reset,
		}

		var r = confirm(_FlatsomeCustomizerReset.confirm)

		if (!r) return

		$resetButton.attr('disabled', 'disabled')

		$.post(ajaxurl, data, function () {
			wp.customize.state('saved').set(true)
			location.reload()
		})
	})

	$clearTypographyCache.on('click', function (event) {
		event.preventDefault()

		const data = {
			wp_customize: 'on',
			action: 'customizer_clear_typography_cache',
			nonce: _FlatsomeCustomizerReset.nonce.reset,
		}

		const r = confirm(
			'Are you sure you want to clear typography cache and locally downloaded font files?'
		)

		if (!r) return

		$clearTypographyCache.prop('disabled', true)

		$.post(ajaxurl, data)
			.done(({ success }) => {
				if (!success) return
				console.log(
					'Flatsome: Typography cache and locally saved fonts files removed successfully'
				)
			})
			.always(() => {
				$clearTypographyCache.prop('disabled', false)
			})
	})
})
