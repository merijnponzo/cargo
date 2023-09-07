// * IS ALSO LOADED IN WP_ADMIN, BEWARE OF GLOBAL ELEMENTS */
document.addEventListener('DOMContentLoaded', () => {

	const player = new Plyr('video', {captions: {active: true}});
	
	
	setTopNavScroll(-100)
	hexagonScroll()

})

const setTopNavScroll = (percentage) => {
	// scrollbar
	const header = document.querySelector('header')

	console.log(header)
	const toolBar = gsap
		.from(header, {
			yPercent: percentage,
			paused: true,
			duration: 0.2,
		})
		.progress(1)

	ScrollTrigger.create({
		start: 'top top',
		end: 99999,
		onUpdate: (self) => {
			if (self.progress > 0.0012300123001230013) {
				header.classList.add('in-view')
			} else {
				header.classList.remove('in-view')
			}
			self.direction === -1 ? toolBar.play() : toolBar.reverse()
		},
	})
}

const hexagonScroll = (text) => {
	const svg = document.querySelector(".hexagon-animation");
	if (svg) {
		const hexagons = svg.querySelectorAll("path");
		// Apply the scale and rotation animation to each hexagon
		gsap.set(hexagons, { strokeWidth: 0, transformOrigin: "center", drawSVG: '0%' });
		// Create the ScrollTrigger to check when the SVG is visible
		ScrollTrigger.create({
			trigger: svg,
			start: "top 80%", // Adjust the start position as needed
			end: "bottom 20%", // Adjust the end position as needed
			onEnter: () => {
				// Stagger the animation for all the path elements
				hexagons.forEach((hexagon, index) => {
					gsap.to(hexagon, {
						duration: 1,
						drawSVG: '100%',
						rotation: 0,
						delay: index * 0.01, // Adjust the stagger delay as needed
						strokeWidth: 20,
						opacity: 1,
						rotationZ: 360,
						ease: "power3.inOut"
					});
				});
			},
			onLeaveBack: () => {
				// Reset the animation when scrolling back up
				gsap.set(hexagons, { rotation: 0, drawSVG: '0%' });
			},
			markers: false // Remove this line to hide the markers
		});
	}
}
