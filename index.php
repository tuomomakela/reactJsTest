<!DOCTYPE html>
<html>
  <head>
    <script src="//cdnjs.cloudflare.com/ajax/libs/react/0.12.2/react-with-addons.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/react/0.12.2/JSXTransformer.js"></script>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
	<link rel="stylesheet" type="text/css" href="style.css" />
  </head>
  <body>
    <div id="content"></div>
    <script type="text/jsx">
		var List = React.createClass({
			getInitialState: function() {
				var data = [
					{name: "A"},
					{name: "B"},
					{name: "C"}
				];
				// set isEdited false for every item
				for (var i = 0; i < data.length; ++i) {
					data[i].isEdited = false;
				}
				return {
					data: data
				};
			},
			/* start editing name of item */
			handleEdit: function(index) {
				var data = this.state.data;
				data[index] = React.addons.update(
					this.state.data[index], {
						isEdited: {$set: true}
					}
				);
				this.setState(data);
				console.log(this.state.data[index]);
			},
			/* save change of name */
			handleSave: function(index) {
				// ajax to handle save
				var data = this.state.data;
				data[index] = React.addons.update(
					this.state.data[index], {
						name: {$set: this.refs["name_"+index].getDOMNode().value.trim()},
						isEdited: {$set: false}
					}
				);
				this.setState(data);
				console.log(this.state.data[index]);
			},
			/* cancel changing a name */
			handleCancel: function(index) {
				var data = this.state.data;
				data[index] = React.addons.update(
					this.state.data[index], {
						isEdited: {$set: false}
					}
				);
				this.setState(data);
				console.log(this.state.data[index]);
			},
			handleDelete: function(index) {
				// ajax to handle delete
				var data = this.state.data;
				data.splice(index, 1);
				this.setState(data);
				console.log(this.state.data);
			},
			handleSubmit: function(event) {
				event.preventDefault();
				var data = this.state.data;
				data[data.length] = {
					name: this.refs.newName.getDOMNode().value.trim(),
					isEdited: false
				}
				// ajax to handle save
				this.setState(data);
				this.refs.newName.getDOMNode().value = '';
			},
			render: function() {
				return(
					<ul className="list">
					{ 
						this.state.data.map(function(item, i) {
							return (
								<li className="listElement" ref={"li_"+i}>
									<div className="textElem">
										{
											item.isEdited
												? <span>
													<input type="text" defaultValue={item.name} ref={"name_"+i} />
													<input type="button" value="Save" onClick={this.handleSave.bind(this,i)} />
													<input type="button" value="Cancel" onClick={this.handleCancel.bind(this,i)} />
												  </span>
												: <span key={i} onClick={this.handleEdit.bind(this,i)}> {item.name} </span>
										}
									</div>
									<div className="deleteElem" onClick={this.handleDelete.bind(this,i)}>
										[x]
									</div>
								</li>
							);
						}, this)
					}
						<li className="listElement">
							<form className="createNewForm" onSubmit={this.handleSubmit}>
								<div className="textElem">
									<input type="text" placeholder="New item" ref="newName" />
								</div>
								<div className="saveBtnElem">
									<input type="submit" value="Save" />
								</div>
							</form>
						</li>
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