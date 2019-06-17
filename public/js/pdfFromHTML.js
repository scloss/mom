function pdfToHTML(divName,divTitle){
  var printContents = document.getElementById(divName).innerHTML;
         var printContentsTableMeeting = document.getElementById("tableMeeting");
         var printContents1 = document.getElementById(divTitle).innerHTML;     
          //var divToPrint = document.getElementById('tableMeeting');
        var htmlToPrint = '' +
            '<style type="text/css">' +
            'h4{text-align:center;}'+
            'table{width:980;}' +
            'table,table td{' +
            'border:1px solid #000;' +
            'border-collapse: collapse;'+
        'overflow:auto;'+
        'word-wrap:break-word;'+
        'margin-top:5%;'+
        'text-align:center;'+
            '}' +
            '</style>';
        //htmlToPrint += printContents.outerHTML;
        newWin = window.open("");

        newWin.document.write(printContents1);
        newWin.document.write(htmlToPrint);
        newWin.document.write(printContents);

var pdf = new jsPDF();
source = newWin.document.getElementById("tableMeeting");//$('#tableMeeting')[0];

specialElementHandlers = {
	'#bypassme': function(element, renderer){
		return true
	}
}
margins = {
    top: 50,
    left: 60,
    width: 545
  };

pdf.fromHTML(
  	source // HTML string or DOM elem ref.
  	, margins.left // x coord
  	, margins.top // y coord
  	, {
  		'width': margins.width // max width of content on PDF
  		, 'elementHandlers': specialElementHandlers
  	},
  	function (dispose) {
  	  // dispose: object with X, Y of the last line add to the PDF
  	  //          this allow the insertion of new lines after html
        pdf.save('html2pdf.pdf');
      }
  )		
}

function demoFromHTML() {
        var pdf = new jsPDF('p', 'pt', 'letter');
        // source can be HTML-formatted string, or a reference
        // to an actual DOM element from which the text will be scraped.
        source = $('#body_id')[0];

        // we support special element handlers. Register them with jQuery-style 
        // ID selector for either ID or node name. ("#iAmID", "div", "span" etc.)
        // There is no support for any other type of selectors 
        // (class, of compound) at this time.
        specialElementHandlers = {
            // element with id of "bypass" - jQuery style selector
            '#bypassme': function (element, renderer) {
                // true = "handled elsewhere, bypass text extraction"
                return true
            }
        };
        margins = {
            top: 80,
            bottom: 60,
            left: 40,
            width: 522
        };
        // all coords and widths are in jsPDF instance's declared units
        // 'inches' in this case
        pdf.fromHTML(
        source, // HTML string or DOM elem ref.
        margins.left, // x coord
        margins.top, { // y coord
            'width': margins.width, // max width of content on PDF
            'elementHandlers': specialElementHandlers
        },

        function (dispose) {
            // dispose: object with X, Y of the last line add to the PDF 
            //          this allow the insertion of new lines after html
            pdf.save('Test.pdf');
        }, margins);
    }