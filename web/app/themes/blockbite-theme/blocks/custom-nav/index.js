(function (wp) {

const ServerSideRender = wp.serverSideRender;
const blockName = "blockbite/custom-nav";

const { registerBlockType } = wp.blocks;
const { createElement } = wp.element;

registerBlockType(blockName, {
	title: "Custom Nav",
	description: "A custom nav block type.",
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