(function (wp) {

const ServerSideRender = wp.serverSideRender;
const blockName = "blockbite/custom-diensten-list";

const { registerBlockType } = wp.blocks;
const { createElement } = wp.element;

registerBlockType(blockName, {
	title: "Custom Diensten List",
	description: "A custom diensten list block type.",
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