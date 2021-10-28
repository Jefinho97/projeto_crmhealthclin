
// clone materiais
$(".clonar").click(function() {
    $(".clone-form-mat").last().clone().appendTo("#form-mat");
});

// clone diarias
$(".clonar2").click(function() {
    $(".clone-form-dia").last().clone().appendTo("#form-dia");
});

// clone profissionais 
$(".clonar3").click(function() {
    $(".clone-form-prof").last().clone().appendTo("#form-prof");
});

