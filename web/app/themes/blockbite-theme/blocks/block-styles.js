(function (wp) {
  //registerBlockVariations

  console.log("custom blockstyles are loaded, 1.0");

  if (typeof wp !== "undefined") {
    document.addEventListener("DOMContentLoaded", function () {
      if (typeof wp.blocks !== "undefined") {
        console.log("custom blockstyles are loaded, 1.0");

        // variation
        wp.blocks.registerBlockVariation("core/categories", {
          name: "blog-filter",
          title: "Blog Filters",
          icon: "category",
          isDefault: false,
          attributes: { taxonomy: "filter" },
        });

        wp.blocks.registerBlockStyle("blockbite/visual", [
          {
            name: "cargo",
            title: "cargo",
          },
        ]);

        wp.blocks.registerBlockStyle("blockbite/group", [
          {
            name: "cargo",
            title: "cargo",
          },
        ]);

      

        wp.blocks.registerBlockStyle("core/button", [
          {
            name: "primary",
            title: "primary",
          },
        ]);
        wp.blocks.registerBlockStyle("core/column", [
          {
            name: "cargo",
            title: "cargo",
          },
        ]);
        wp.blocks.registerBlockStyle("core/image", [
          {
            name: "cargo",
            title: "cargo",
          },
        ]);
        wp.blocks.registerBlockStyle("core/heading", [
          {
            name: "cargo",
            title: "cargo",
          },
          {
            name: "chapter",
            title: "chapter",
          },
        ]);

        wp.blocks.registerBlockStyle("core/post-title", [
          {
            name: "cargo",
            title: "cargo",
          },
        ]);

        wp.blocks.registerBlockStyle("core/group", [
          {
            name: "cargo",
            title: "cargo",
          }
        ]);
      }
    });
  }
})(window.wp);
