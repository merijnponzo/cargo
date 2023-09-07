import SnapSlider from '@tannerhodges/snap-slider'

export const snapSlider = () => {
	// LOGOBAR AUTOPLAY SLIDER
	let logoSliderIndex = -1

	const logobar = document.querySelector('.logobar')
	if (logobar) {
		const logoSlider = new SnapSlider('.logobar', {
			id: 'logobar',
			nav: '.logobar__nav',
			start: 'left',
			on: {
				'change.focusin': () => {
					logoSliderIndex = 0
					clearInterval(logoSliderTimer)
				},
				'change.click': () => {
					logoSliderIndex = 0
					clearInterval(logoSliderTimer)
				},
			},
		})
		const logoSliderTimer = setInterval(() => {
			logoSliderIndex++
			if (logoSliderIndex > logoSlider.slides.length) {
				logoSliderIndex = 0
			}
			logoSlider.goto(logoSliderIndex, { focus: false })
		}, 2000)
	}
}

export default snapSlider
