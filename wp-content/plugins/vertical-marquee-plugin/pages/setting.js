// JavaScript Document
function _vm_submit()
{
	if(document.vm_form.vm_text.value=="")
	{
		alert("Please enter marquee message.")
		document.vm_form.vm_text.focus();
		return false;
	}
	else if(document.vm_form.vm_group.value == "" || document.vm_form.vm_group.value == "Select")
	{
		alert("Please select message group.")
		document.vm_form.vm_group.focus();
		return false;
	}
}

function _vm_delete(id)
{
	if(confirm("Do you want to delete this record?"))
	{
		document.frm_vm_display.action="options-general.php?page=vertical-marquee-plugin&ac=del&did="+id;
		document.frm_vm_display.submit();
	}
}	

function _vm_redirect()
{
	window.location = "options-general.php?page=vertical-marquee-plugin";
}

function _vm_help()
{
	window.open("http://www.gopiplus.com/work/2012/06/30/vertical-marquee-wordpress-plugin/");
}		  