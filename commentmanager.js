function updateComments() {
	$.get("getcomments.php?pid="+getPID(), function(data) {
		$("#comments").html(data);
	});
}

function addCommentField(id) {
	var geturl = "addcomment.php?pid="+getPID();
	if (id === undefined) {
		id = "";
	}
	if (id !== "") {
		geturl += "&par="+id;
	}
	$.get(geturl, function(data) {
		
		
			$("#addcomment"+id).html(data);
		
	});
	return false;
}

$("#newcomment").click(function() {
	addCommentField();
});

updateComments();