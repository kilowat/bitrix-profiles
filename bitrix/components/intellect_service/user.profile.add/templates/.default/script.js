var app=app||{};$(document).ready(function(){$(".vtip").tipTip({defaultPosition:"right",maxWidth:"340px",delay:100}),$(".profile-info input[type=radio]").change(function(){var i=$(this).data("url");$.ajax({url:i,method:"get"}).done(function(i){var t=$(i).find(".profile-input-block").children(),p=$(".profile-input-block");p.children().remove(),p.append(t),$(".vtip").tipTip({defaultPosition:"right",maxWidth:"340px",delay:100})})})});