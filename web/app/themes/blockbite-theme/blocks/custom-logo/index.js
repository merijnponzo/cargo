(function (wp) {

const ServerSideRender = wp.serverSideRender;
const blockName = "blockbite/custom-logo";

const { registerBlockType } = wp.blocks;
const { createElement } = wp.element;

registerBlockType(blockName, {
	title: "Custom Logo",
	description: "A custom logo blocktype.",
	category: "blockbite",
	edit(props) {
		return createElement(ServerSideRender, {
			block: blockName,
			attributes: props.attributes,
		})
	},
	save() {
		return null;
	},
});
})(window.wp);