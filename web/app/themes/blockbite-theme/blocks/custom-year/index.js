(function (wp) {

const ServerSideRender = wp.serverSideRender;
const blockName = "blockbite/custom-year";

const { registerBlockType } = wp.blocks;
const { createElement } = wp.element;

registerBlockType(blockName, {
	title: "Custom year",
	description: "A custom year blocktype.",
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