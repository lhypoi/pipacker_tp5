	// console.log($("#pic_file").get(0).files[0]);
	// console.log($(".img_type").val());
	// console.log($(".camera_type").val());
	// console.log($(".aperture_type").val());
	// console.log($(".iso_type").val());
	// console.log($(".shutter_type").val());

	// console.log($(".works_title").find('input').val())
	// console.log($(".works_profile").find('textarea').val())
	// console.log($(".atlas_id").find('input').val())
	// console.log($(".works_tags").find('input').val())
$(function(){
	// console.log($(".send_works"));
	function works_option(){

	};
	works_option.prototype={
		send:function(){
			$(".tag_input_box").keyup(function(e) {
				var tag_box = $(this).parent();
				var this_val = $(this).val();
				// console.log(e);
				if(e.keyCode == 13 && this_val != "")
				{
					// 当键盘事件是回车的时候，新增加
					tag_box.prepend("<span class='newtag'>#"+this_val+",</span>");
					$(this).val("");
				}
				else if(e.keyCode == 8)
				{
					// var remove_el = tag_box.children().eq(0);
					// $.post(works_url,{id:remove_el.attr('data-id')},function(rtnData){
					// 	remove_el.remove();
					// })
					tag_box.find('span').eq(0).remove();
				}
			});
			$(".send_works").on("click",function(){
				if(localStorage.getItem("user_id")>0){
					var works_para =[
					$(".camera_type").val(),$(".aperture_type").val(),$(".iso_type").val(),$(".shutter_type").val()
					];
					// var works_data = {
					// 	"works_title":$(".works_title").find('input').val(),
					// 	"works_profile":$(".works_profile").find('textarea').val(),
					// 	// "user_id":$_SESSION['user_id'],
					// 	// "works_src":fd,
					// 	"atlas_id":$(".atlas_id").find('input').val(),
					// 	"works_para":works_para,
					// 	"works_type":$(".img_type").val(),
					// 	"works_tags":$(".works_tags").find('input').val()
					// }
					var fd = new FormData();
					var files_a = $("#pic_file").get(0).files;
					for (var i=0;i<files_a.length;i++){
		                fd.append("pic_src[]",files_a[i]);
		                // console.log(files_a[i]);
		            }
					// fd.append("pic_src",$("#pic_file").get(0).files[0]);
					var tag_text = $(".tag_box").find('span');
					for(var i=0;i<tag_text.length;i++){
						fd.append("works_tags[]",tag_text[i].innerHTML);
					}
					fd.append("works_title",$(".works_title").find('input').val());
					fd.append("works_profile",$(".works_profile").find('textarea').val());
					fd.append("atlas_id",$(".atlas_id").find('input').val());
					fd.append("works_para",works_para);
					fd.append("works_type",$(".img_type").val());
					// fd.append("works_tags",$(".tag_box").find('span').val());
					fd.append("user_id",localStorage.getItem("user_id"));
					fd.append("works_browse",0);
					// console.log();
					// $.post(works_url,works_data,function(data){
						
					// });

					$.ajax({
							url:works_url,
							type:"post",
				        	contentType:false,
				        	processData:false,
				        	data:fd,
				        	success:function  (rtnData){

				        	}
						});
				}else{
					alert('请先登录!');
					return;
				}
				
			});
		},
		init:function(){
			this.send();
		}
	}
	var works_option = new works_option();
	works_option.init();
});