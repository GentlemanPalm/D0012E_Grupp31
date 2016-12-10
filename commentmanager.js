function updateComments() {
	$.get("getcomments.php?pid="+getPID(), function (data) {
		$("#comments").html(data);
	});
}

function updateReviews() {
	$.get("getreviews.php?pid="+getPID(), function (data) {
		$("#reviews").html(data);
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

$("#newreview").click(function() {
	$.get("addreview.php?pid="+getPID(), function (data) {
		$("#addreview").html(data);
	});
});


updateComments();
updateReviews();