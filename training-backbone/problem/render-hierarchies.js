$(document).ready(function () {
	var TreeView = Backbone.Marionette.CompositeView.extend({
		template: "#node-template",
		tagName: "ul",

		initialize: function () {
			this.collection = this.model.nodes;
		},

		appendHtml: function (collectionView, itemView) {

			collectionView.$("li:first").append(itemView.el);

		}
	});

	var TreeRoot = Backbone.Marionette.CollectionView.extend({
		itemView: TreeView
	});

	treeData = [
  {
    nodeName: "top level 234234234",
    nodes: [
      {
        nodeName: "2nd level, item 1",
        nodes: [
          { nodeName: "3rd level, item 1" },
          { nodeName: "3rd level, item 2" },
          { nodeName: "3rd level, item 3" }
        ]
      },
      {
        nodeName: "2nd level, item 2",
        nodes: [
          { nodeName: "3rd level, item 4" },
          { nodeName: "3rd level, item 5",
              nodes: [
                  { nodeName: "4th level, item 1" },
                  { nodeName: "4th level, item 2" },
                  { nodeName: "4th level, item 3" }
              ]
          },
          { nodeName: "3rd level, item 6" }
        ]
      }
    ]
  },
  {
    nodeName: "top level 2",
    nodes: [
      {
        nodeName: "2nd level, item 3",
        nodes: [
          { nodeName: "3rd level, item 7" },
          { nodeName: "3rd level, item 8" },
          { nodeName: "3rd level, item 9" }
        ]
      },
      {
        nodeName: "2nd level, item 4",
        nodes: [
          { nodeName: "3rd level, item 10" },
          { nodeName: "3rd level, item 11" },
          { nodeName: "3rd level, item 12" }
        ]
      }
    ]
  }

];
	TreeNode = Backbone.Model.extend({
		initialize: function () {
			var nodes = this.get('nodes');
			if(nodes) {
				this.nodes = new TreeNodeCollection(nodes);
				this.unset("nodes");
			}
		}
	});

	TreeNodeCollection = Backbone.Collection.extend({
		model: TreeNode
	});

	var tree = new TreeNodeCollection(treeData);

	var treeView = new TreeRoot({
		collection: tree
	});

	treeView.render();

	$("#tree").html(treeView.el);
});