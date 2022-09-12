<style>
:root{
    --lightblue:#cce5ff;
    --lightgreen: #ccffcc;
    --lightpink: #e6d0de;
    --lightyellow: #ffffcc;
    --lightsilver: #647687;
}
*{
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}
li{
    list-style: none;
}
    .header_navbar{
        width:100%;
        border-top:1px solid #eee2ea;
        border-bottom:1px solid #eee2ea;
        padding: 10px 10%;
    }
    .arrow {
border: solid black;
border-width: 0 3px 3px 0;
display: inline-block;
padding: 3px;
cursor: pointer;
}
.up {
transform: rotate(-135deg);
-webkit-transform: rotate(-135deg);
position:absolute;
top: 5px;
left: 10px;
}
.menu-down{
transform: rotate(45deg);
-webkit-transform: rotate(45deg);

}
.down {
transform: rotate(45deg);
-webkit-transform: rotate(45deg);
position:absolute;
top: 10px;
left: 10px;
}
.right {
transform: rotate(-45deg);
-webkit-transform: rotate(-45deg);
}

.left {
transform: rotate(135deg);
-webkit-transform: rotate(135deg);
}
.header_navbar__list{
margin: 0;
text-align: center;
justify-content: right;
}
.header_navbar__list__items{
padding: 0px 0px 0px 30px;
}
.header_navbar__list__items__menu{
display: none;
}
.header_navbar__list__items__menu--hover:hover {
cursor: pointer;
background-color: #cce5ff;
}
.header_navbar__list__items--menu:hover .header_navbar__list__items__menu{
width: 85%;
position: absolute;
display: block;
text-align: center;
z-index:999;
left: 15%;
cursor: pointer;
background-color: #cce5ff;
border-top: 1px solid black;
}
.header_navbar__list__items--menu{
text-align: center;
position: relative;
color: #006ad7;
}
.header_navbar__list__items__menu--hover, .header_navbar__list__items__menu, .header_navbar__list__items__menu--logout{
cursor: pointer;
padding: 10px;
}
.header_navbar__list__items__menu--first{
top: 44px;
}
.header_navbar__list__items__menu--last{
top: 88px;
}
.notice{
width: 80%;
padding: 10px;
margin: 50px 10%;
background-color: #ccffcc;
border-radius: 5px;
}
p{
margin:0;
}
.search_box{
width: 80%;
margin: 0px 10%;
border: 1px solid black;
padding: 50px 65px;
}
.search_box__form{
margin-right: 30px;
margin-bottom: 30px;
}
.search_box__form--input{
width: 50%;
}
.search_box__btn{
justify-content:space-between;
}
.search_box__btn__items{
width: 10%;
padding: 5px;
background-color: #e6d0de;
border-radius: 5px;
border: none;
}
.search_box__btn__items--blue{
color: white;
background-color: #006ad7;
}
.data{
width: 80%;
margin: 50px 10%;
}
.paginate{
text-align: right;
}
.sort{
position: relative;
}
.Admin, .User{
background-color: #cce5ff;
}
.flow_url{
width: 80%;
margin: 50px 10%;
}
.form_input{
margin: 20px 0px;
}
.form_container{
width: 80%;
margin: 50px 10%;
}
.form_box{
border: 1px solid black;
}
.submit_box{
margin: 20px 0;
justify-content:space-between;
}
.avatar_profile{
width:10%;
border: 1px solid black;
}
</style>