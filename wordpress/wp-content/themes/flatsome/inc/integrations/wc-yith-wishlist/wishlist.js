Flatsome.behavior('wishlist', {
	attach: function (context) {
		jQuery('.wishlist-button', context).each(function (index, element) {
			'use strict'

			jQuery(element).on('click', function (e) {
				var $this = jQuery(this)
				// Browse wishlist
				if (
					$this
						.parent()
						.find(
							'.yith-wcwl-wishlistexistsbrowse, .yith-wcwl-wishlistaddedbrowse'
						).length
				) {
					window.location.href = $this
						.parent()
						.find(
							'.yith-wcwl-wishlistexistsbrowse a, .yith-wcwl-wishlistaddedbrowse a'
						)
						.attr('href')
					return
				}
				$this.addClass('loading')
				// Delete or add item (only one of both is present).
				$this.parent().find('.delete_item').trigger('click')
				$this.parent().find('.add_to_wishlist').trigger('click')

				e.preventDefault()
			})
		})

		markAdded()
	},
})

jQuery(function ($) {
  var flatsomeAddToWishlist = function () {
		$('.wishlist-button').removeClass('loading')
		markAdded()

		$.ajax({
			data: {
				action: 'flatsome_update_wishlist_count',
			},
			success: function (data) {
				var $icon = $('i.wishlist-icon')
				$icon.addClass('added')
				if (data == 0) {
					$icon.removeAttr('data-icon-label')
				} else if (data == 1) {
					$icon.attr('data-icon-label', '1')
				} else {
					$icon.attr('data-icon-label', data)
				}
				setTimeout(function () {
					$icon.removeClass('added')
				}, 500)
			},

			url: yith_wcwl_l10n.ajax_url,
		})
	}

	$('body').on(
		'added_to_wishlist removed_from_wishlist',
		flatsomeAddToWishlist
	)
})

function markAdded() {
	jQuery('.wishlist-icon').each(function () {
		var $this = jQuery(this)

		if (
			$this.find('.wishlist-popup .yith-wcwl-add-to-wishlist.exists')
				.length
		) {
			$this.find('.wishlist-button').addClass('wishlist-added')
		} else {
			$this.find('.wishlist-button').removeClass('wishlist-added')
		}
	})
}
