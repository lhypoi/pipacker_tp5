
function browse_img_hf(data){
	this.data = data;
	this.pre_lock = true;
  this.next_lock = true;
  this.ew = 0;
}
browse_img_hf.prototype = {
	init:function(){
		this.click_btn();
	},
	click_btn:function(){
		var that = this;
		this.data.browse_img.on('click',function(e){
          var this_elm = $(e.target);
          if(this_elm.hasClass('pre_btn')){
            that.next_lock = true;
          	// console.log(that.pre_lock);
            that.next_lock = true;
            if(that.pre_lock){
            	that.ew = 1;
              that.browse_img_n();
            }else{
              alert("已经是第一张了");
            }
            // $browse_img.find('img').attr('src','__PUBLIC_PIPACKER__/pipacker/images/bg.jpg');
          }else if(this_elm.hasClass('next_btn')){
            that.pre_lock = true;
            if(that.next_lock){
            	that.ew=0;
              that.browse_img_n();
            }else{
              alert("已经是最后一张了");
            } 
          }
        })
	},
	browse_img_n:function(){
		var that = this;
		$.ajax({
          url: that.data.url,
          type: 'get',
          data: {'works_id':that.data.works_id,'browse':that.ew},
        })
        .done(function(rdata) {
          if(!$.isEmptyObject(rdata)){
            var redata = $.parseJSON(rdata);
            if(0==redata.status){
                that.data.browse_img.find("img").attr("src",redata.rearray.works_src);
                that.data.thumbnails.text(redata.rearray.works_title);
                // that.data.works_tags.text(redata.rearray.works_tags);
                // datapp.each( function(index, el) {
                //   that.data.user_name.text(datapp[index].user_name);
                // })
                // console.log(datapp);
                if(typeof(that.data.para)!='undefined'){
                  // console.log(that.data.para);
                  that.data.para.eq(1).text(redata.rearray.works_type);
                  that.data.para.eq(2).text(redata.rearray.works_para[0]);
                  that.data.para.eq(3).text(redata.rearray.works_para[1]);
                  that.data.para.eq(4).text(redata.rearray.works_para[2]);
                  that.data.para.eq(5).text(redata.rearray.works_para[3]);
                }
                if(typeof(that.data.tags)!='undefined'){
                  // console.log(that.data.tags)
                  that.data.tags.each( function(index, el) {
                    // statements
                    that.data.tags.eq("index").text("#"+redata.rearray.works_tags[index]);
                  });
                }                
                that.data.works_id = redata.rearray.works_id;
            }else{
              if(1==that.ew){
                that.pre_lock = false;
                that.next_lock = true;
                alert("已经是第一张了");
              }else{
                that.pre_lock = true;
                that.next_lock = false;
                alert("已经是最后一张了");
              }
            }
          }else{
            alert("页面走丢了");
          }
      });
	}
}