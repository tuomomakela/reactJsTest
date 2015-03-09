 
var cloneWithProps = React.addons.cloneWithProps;
 
var SmartSortable = React.createClass({
  getDefaultProps: function() {
    /* Changing "ul" to React.DOM.ul -> "Do not pass React.DOM.ul to JSX or createFactory. Use the string "ul" instead." */
    return {component: "ul", childComponent: "li"};
  },
 
  render: function() {
	//console.log(this.props);
    /* create new object: props = this.props is just not working. Don't know why */
	var props = $.extend({}, this.props);
	//console.log(props);
    delete props.children;
    //console.log(props);
    return React.createElement(this.props.component, props);
  },
 
  /* kutsutaan, kun lista luodaan */
  componentDidMount: function() {
	console.log("componentDidMount");
    $(this.getDOMNode()).sortable({stop: this.handleDrop});
	// wrote here another option, but this is lacking a test of empty children */
    //this.getChildren().forEach(function(child, i) {
	this.props.children.map(function(child, i) {
	  /* appending <li /> */
      $(this.getDOMNode()).append('<' + this.props.childComponent + ' />');
	  /* node is what was appended */
      var node = $(this.getDOMNode()).children().last()[0];
	  /* setting just variable */
      node.dataset.reactSortablePos = i;
	  console.log(child);
	  console.log(node);
	  /* calling render child == this.props.children */
      React.render(cloneWithProps(child), node);
    }.bind(this));
  },
 
  /* kutsutaan, kun lista päivittyy */
  componentDidUpdate: function() {
	console.log("componentDidUpdate");
    var childIndex = 0;
    var nodeIndex = 0;
    //var children = this.getChildren();
    var children = this.props.children;
    var nodes = $(this.getDOMNode()).children();
    var numChildren = children.length;
    var numNodes = nodes.length;
 
	/* käydään läpi 0..n */
    while (childIndex < numChildren) {
	  /* adding new item to the list */
      if (nodeIndex >= numNodes) {
		console.log(nodeIndex+' >= '+numNodes);
		/* create <li /> */
        $(this.getDOMNode()).append('<' + this.props.childComponent + '/>');
		/* nodes -arrayn viimeiseksi kyseinen li */
        nodes.push($(this.getDOMNode()).children().last()[0]);
		/* astetaan objektiin muuttuja reactSortablePos */
        nodes[numNodes].dataset.reactSortablePos = numNodes;
        numNodes++;
      }
	  /* calling render */
      React.render(cloneWithProps(children[childIndex]), nodes[nodeIndex]);
      childIndex++;
      nodeIndex++;
    }
 
    /* removing item from the list */
    while (nodeIndex < numNodes) {
	  console.log("remove item");
      React.unmountComponentAtNode(nodes[nodeIndex]);
      $(nodes[nodeIndex]).remove();
      nodeIndex++;
    }
  },
 
  /* removing entire component */
  componentWillUnmount: function() {
	conlose.log("componenWillUnmount");
    $(this.getDOMNode()).children().get().forEach(function(node) {
      React.unmountComponentAtNode(node);
    });
  },
 
  /* this not necessary */
  getChildren: function() {
    // TODO: use mapChildren()
    return this.props.children || [];
  },
 
  handleDrop: function() {
    console.log("handleDrop");
	/* new order is array of posIndex in old order */
    var newOrder = $(this.getDOMNode()).children().get().map(function(child, i) {
      var rv = child.dataset.reactSortablePos;
      child.dataset.reactSortablePos = i;
      return rv;
    });
	console.log(newOrder);
    this.props.onSort(newOrder);
  }
});