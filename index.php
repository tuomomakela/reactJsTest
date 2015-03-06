<!DOCTYPE html>
<html>
  <head>
    <script src="//cdnjs.cloudflare.com/ajax/libs/react/0.12.2/react.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/react/0.12.2/JSXTransformer.js"></script>
  </head>
  <body>
    <div id="content"></div>
    <script type="text/jsx">
		var ListElement = React.createClass({
			getInitialState: function() {
				return {
					isEdited: this.props.isEdited === true
				};
			},
			handleEdit: function(event) {
				this.setState({isEdited: true});
				console.log("click registered");
			},
			render: function() {
				var textData = this.state.isEdited
					? <span><input type="text" value={this.props.name} /></span>
					: <span onClick={this.handleEdit}> {this.props.name} </span>
					
				return(
					<li className="listElement">
						{textData}
					</li>
				);
			}
		});
		var List = React.createClass({
			getInitialState: function() {
				return {
					data: [
						{name: "A", isEdited: false},
						{name: "B", isEdited: false},
						{name: "C", isEdited: false}
					]
				}
			},
			render: function() {
				var itemData = this.state.data.map(function(item) {
					return (
						<ListElement {...item} />
					);
				});
				return(
					<ul>
						{itemData}
					</ul>
				);
			}
		});
		React.render(
			<List />,
			document.getElementById('content')
		);
    </script>
  </body>
</html>