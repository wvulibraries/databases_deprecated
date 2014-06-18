<?php ?>

<script type="text/javascript">
function confirmDelete() {
	var agree=confirm("Delete Database?");
	if (agree) {
		return true;
	}
	else {
		return false ;
	}
}
</script>