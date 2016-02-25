$(document).ready(function()
{
	var currentSlide;
	var programName;
	var term;

	// Set up form paging
	$('.general-form').slick({
  		arrows: false,
  		fade: true,
  		draggable: false,
  		infinite: false,
  		onInit : function () 
		{
			currentSlide = 0;

			$(".form-context").css("display", "block");
			$(".form-pagination").css("display", "block");

		}
	});

	// Set up form validation
	$(".general-form").validetta({
		display : 'inline',
		onError : function() {
			$('.general-form').slickGoTo(0);
			$(".form-pagination li:nth-child(2)").addClass("active");
			$(":not(.form-pagination li:nth-child(2))").removeClass("active");
		}
	});

	currentSlide = currentSlide + 2;
	$(".form-pagination li:nth-child("+currentSlide+")").addClass("active");
	$(":not(.form-pagination li:nth-child("+currentSlide+"))").removeClass("active");

	// Previous button event handler
	$(".form-pagination .prev-btn").click(function()
	{	
		$('.general-form').slickPrev();

		currentSlide = $('.general-form').slickCurrentSlide();
		currentSlide = currentSlide + 2;
		$(".form-pagination li:nth-child("+currentSlide+")").addClass("active");
		$(":not(.form-pagination li:nth-child("+currentSlide+"))").removeClass("active");
	});

	// page 1 event
	$(".form-pagination li:nth-child(2) a").click(function()
	{
		$('.general-form').slickGoTo(0);

		$(".form-pagination li:nth-child(2)").addClass("active");
		$(":not(.form-pagination li:nth-child(2))").removeClass("active");
	});

	// page 2 event
	$(".form-pagination li:nth-child(3) a").click(function()
	{
		$('.general-form').slickGoTo(1);
		$(".form-pagination li:nth-child(3)").addClass("active");
		$(":not(.form-pagination li:nth-child(3))").removeClass("active");

	});

	// page 3 event
	$(".form-pagination li:nth-child(4) a").click(function()
	{
		$('.general-form').slickGoTo(2);
		$(".form-pagination li:nth-child(4)").addClass("active");
		$(":not(.form-pagination li:nth-child(4))").removeClass("active");
	});

	// page 4 event
	$(".form-pagination li:nth-child(5) a").click(function()
	{
		$('.general-form').slickGoTo(3);
		$(".form-pagination li:nth-child(5)").addClass("active");
		$(":not(.form-pagination li:nth-child(5))").removeClass("active");
	});

	// page 5 event
	$(".form-pagination li:nth-child(6) a").click(function()
	{
		$('.general-form').slickGoTo(4);
		$(".form-pagination li:nth-child(6)").addClass("active");
		$(":not(.form-pagination li:nth-child(6))").removeClass("active");
	});

	// next button event handler
	$(".form-pagination .next-btn").click(function()
	{
		$('.general-form').slickNext();
		
		currentSlide = $('.general-form').slickCurrentSlide();
		currentSlide = currentSlide + 2;
		$(".form-pagination li:nth-child("+currentSlide+")").addClass("active");
		$(":not(.form-pagination li:nth-child("+currentSlide+"))").removeClass("active");
	});

	$(":input").change(function () 
	{
		programName = $('input[name="programName"]').val();
		term = $('select[name="term"]').val();

		if(programName == "")
			programName = "not set";

		if(term == "")
			term = "not set";

		$('.programName-context span').text(programName);
		$('.term-context span').text(term);
	});
});