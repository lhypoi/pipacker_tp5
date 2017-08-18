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
			$(".send_works").on("click",function(){
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
				fd.append("pic_src",$("#pic_file").get(0).files[0]);
				fd.append("works_title",$(".works_title").find('input').val());
				fd.append("works_profile",$(".works_profile").find('textarea').val());
				fd.append("atlas_id",$(".atlas_id").find('input').val());
				fd.append("works_para",works_para);
				fd.append("works_type",$(".img_type").val());
				fd.append("works_tags",$(".works_tags").find('input').val());
				// fd.append("user_id",$_SESSION['user_id']);
				// console.log(works_data);
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
			});
		// console.log($("#pic_file").get(0).files[0]);
		},
		init:function(){
			this.send();
		}
	}
	var works_option = new works_option();
	works_option.init();
});