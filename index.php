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
					isEdited: this.props.isEdited === true,
					name: this.props.name
				};
			},
			/*handleChange: function(event) {
				this.setState({name: event.target.value});
			},*/
			handleEdit: function(event) {
				this.setState({isEdited: true});
				console.log("start editing");
			},
			handleSave: function(event) {
				this.setState({name: this.refs.name.getDOMNode().value.trim()});
				this.setState({isEdited: false});
			},
			handleCancel: function(event) {
				this.setState({isEdited: false});
			},
			render: function() {
				var textData = this.state.isEdited
					? <span>
						<input type="text" defaultValue={this.state.name} ref="name" />
						<input type="button" value="Save" onClick={this.handleSave} />
						<input type="button" value="Cancel" onClick={this.handleCancel} />
					  </span>
					: <span onClick={this.handleEdit}> {this.state.name} </span>
					
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