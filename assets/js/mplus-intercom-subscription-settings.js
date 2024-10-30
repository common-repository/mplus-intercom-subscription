(function($){
    let getValue = function(fieldType, fieldName) {
        if(fieldType == 'checkbox'){
            if($("input[name='"+fieldName+"']").is(":checked")){
                fieldValue = $("input[name='"+fieldName+"']").val();
            }else{
                fieldValue = "";
            }
        }else{
            if(fieldType == 'radio'){
                if($("input[name='"+fieldName+"']:checked").val() != undefined){
                    fieldValue = $("input[name='"+fieldName+"']:checked").val();
                }else{
                    fieldValue = "";
                }
            }else{
                fieldValue = $("[name='"+fieldName+"']").val();
            }
        }

        return fieldValue;
    }
    $(document).ready(function(){
        // if(location.hash == ""){
        //     $(".mplusis-settings-page").first().show();
        // }else{
        //     let page_id = location.hash.substr(1);
        //     $(".mplusis-settings-page-"+page_id).show();
        // }
        $(".settings-page-submit").click(function(e){
            e.preventDefault();
            let page_id = $(this).data('settings-page');
            let values = {};
            for(field in mplusis_settings.pages[page_id].fields){
                let field_name = field;
                let field_obj = mplusis_settings.pages[page_id].fields[field];
                switch (field_obj.type) {
                    case 'group-fields':
                        for(gFieldKey in field_obj.fields){
                            gFieldObj = field_obj.fields[gFieldKey];
                            let gFieldName = gFieldKey;
                            values[gFieldKey] = getValue(gFieldObj.type, gFieldName);
                        }
                        break;

                    default:
                        values[field] = getValue(field_obj.type, field_name);
                        break;
                }
                // if(field_obj.type == 'checkbox'){
                //     if($("input[name='"+field_name+"']").is(":checked")){
                //         values[field] = $("input[name='"+field_name+"']").val();
                //     }else{
                //         values[field] = "";
                //     }
                // }else{
                //     if(field_obj.type == 'radio'){
                //         if($("input[name='"+field_name+"']:checked").val() != undefined){
                //             values[field] = $("input[name='"+field_name+"']:checked").val();
                //         }else{
                //             values[field] = "";
                //         }
                //     }else{
                //         values[field] = $("[name='"+field_name+"']").val();
                //     }
                // }
            }
            $("#mplusis_base_settings").waitMe({
                effect: 'rotation'
            });
            $.ajax(mplusis_settings.ajaxurl, {
                method: 'post',
                data: {
                    action: 'mplusis_save_settings',
                    values,
                    _wpnonce: mplusis_settings.nonce
                },
                success: function(){
                    $("#mplusis_base_settings").waitMe('hide');
                }
            })
        });

        $("#create_shortcode_page").click(function(e){
            e.preventDefault();
            let me = $(this);
            $("#mplusis_welcome_page").waitMe({
                effect: 'rotation'
            });
            $.ajax(mplusis_settings.ajaxurl, {
                method: 'post',
                data: {
                    action: 'mplusis_create_page_with_shortcode',
                    _wpnonce: mplusis_settings.nonce
                },
                success: function(res){
                    $("#mplusis_welcome_page").waitMe('hide');
                    me.parents(".step-text").html(`Lead generation page created. <a href="${res.data[0]}" target="_blank">View the page.</a>`)

                },
                error: function(){
                    alert("Error creating page.");
                    $("#mplusis_welcome_page").waitMe('hide');
                }
            })

        })

    });
    // $(window).on('hashchange', function () {
    //     let page_id = location.hash.substr(1);
    //     $(".mplusis-settings-page").hide();
    //     $(".mplusis-settings-page-"+page_id).show();
    // });

    document.addEventListener("DOMContentLoaded", function () {
        var $pageManager = document.querySelector(".mplus-Content");
        // let hash = window.location.hash;
        // alert(hash);
        if ($pageManager) {
            new PageManager($pageManager);
        }
    });
    function PageManager(aElem) {
        var refThis = this;
        this.$body = document.querySelector(".mplus-body");
        this.$menuItems = document.querySelectorAll(".mplus-menuItem");
        this.$submitButton = document.querySelector("#mplus-options-submit");
        this.$pages = document.querySelectorAll(".mplus-Page");
        this.$sidebar = document.querySelector(".mplus-Sidebar");
        this.$content = document.querySelector(".mplus-Content");
        //this.$tips = document.querySelector(".mplus-Content-tips");
        this.$links = document.querySelectorAll(".mplus-body a");
        this.$menuItem = null;
        this.$page = null;
        this.pageId = null;
        this.bodyTop = 0;
        //this.buttonText = this.$submitButton.value;
        refThis.getBodyTop(); // If url page change

        //console.debug(refThis);

        window.onhashchange = function () {
            refThis.detectID();
        }; // If hash already exist (after refresh page for example)

        if (window.location.hash) {
            this.bodyTop = 0;
            this.detectID();
        } else {
            var session = localStorage.getItem("mplus-hash");
            this.bodyTop = 0;

            if (session) {
            window.location.hash = session;
            this.detectID();
            } else {
            this.$menuItems[0].classList.add("isActive");
            localStorage.setItem("mplus-hash", "mplusis_welcome_page");
            window.location.hash = "#mplusis_welcome_page";
            }
        } // Click link same hash

        for (var i = 0; i < this.$links.length; i++) {
            this.$links[i].onclick = function () {
                refThis.getBodyTop();
                var hrefSplit = this.href.split("#")[1];

                if (hrefSplit == refThis.pageId && hrefSplit != undefined) {
                refThis.detectID();
                return false;
                }
            };
        } // Click links not WP rocket to reset hash

        var $otherlinks = document.querySelectorAll(
            "#adminmenumain a, #wpadminbar a"
        );

        for (var i = 0; i < $otherlinks.length; i++) {
            $otherlinks[i].onclick = function () {
            localStorage.setItem("mplus-hash", "");
            };
        }
    }
    /*
    * Page detect ID
    */
    PageManager.prototype.detectID = function () {
        this.pageId = window.location.hash.split("#")[1];
        localStorage.setItem("mplus-hash", this.pageId);
        this.$page = document.querySelector(".mplus-Page#" + this.pageId);
        this.$menuItem = document.getElementById("mplus-nav-" + this.pageId);
        //console.debug(this.$page);
        this.change();
    };
    /*
    * Get body top position
    */
    PageManager.prototype.getBodyTop = function () {
        var bodyPos = this.$body.getBoundingClientRect();
        this.bodyTop = bodyPos.top + window.pageYOffset - 47; // #wpadminbar + padding-top .mplus-wrap - 1 - 47
    };
	/*
	* Page change
	*/
	PageManager.prototype.change = function () {
		let refThis = this;
        let $submitButton = document.querySelector("." + this.pageId);
		document.documentElement.scrollTop = refThis.bodyTop; // Hide other pages

		for (var i = 0; i < this.$pages.length; i++) {
			this.$pages[i].style.display = "none";
		}

		for (var i = 0; i < this.$menuItems.length; i++) {
			this.$menuItems[i].classList.remove("isActive");
		} // Show current default page

		this.$page.style.display = "block";
		//this.$submitButton.style.display = "block";

		if (null === localStorage.getItem("mplus-show-sidebar")) {
			localStorage.setItem("mplus-show-sidebar", "on");
		}

		if ("on" === localStorage.getItem("mplus-show-sidebar")) {
			this.$sidebar.style.display = "block";
		} else if ("off" === localStorage.getItem("mplus-show-sidebar")) {
			this.$sidebar.style.display = "none";
			document.querySelector("#mplus-js-tips").removeAttribute("checked");
		}

		// this.$tips.style.display = "block";
		this.$menuItem.classList.add("isActive");
		// this.$submitButton.value = this.buttonText;
		this.$content.classList.add("isNotFull"); // Exception for dashboard

		if (this.pageId == "dashboard") {
			this.$sidebar.style.display = "none";
			// this.$tips.style.display = "none";
			//this.$submitButton.style.display = "none";
			this.$content.classList.remove("isNotFull");
		} // Exception for addons

		if (this.pageId == "addons") {
			//this.$submitButton.style.display = "none";
		} // Exception for database

		if (this.pageId == "database") {
			//this.$submitButton.style.display = "none";
		} // Exception for tools and addons

		if (this.pageId == "tools" || this.pageId == "addons") {
			//this.$submitButton.style.display = "none";
		}

		if (this.pageId == "imagify") {
			this.$sidebar.style.display = "none";
			// this.$tips.style.display = "none";
			//this.$submitButton.style.display = "none";
		}

		if (this.pageId == "intercom-addons" || this.pageId == "mplusis_welcome_page" || this.pageId == "mplusis-license-page") {
            $submitButton.style.display = "none";
		}
    };

})(jQuery)