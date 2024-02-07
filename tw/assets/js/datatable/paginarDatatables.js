/*
 * Este complemento de paginación proporciona controles de paginación para DataTables que
 * coincide con el estilo y la interacción del componente de la cuadrícula de la biblioteca ExtJS.
 *
*   @name  ExtJS style
*   @Summary Paginación en el estilo de ExtJS
*   @author  [Zach Curtis] (http: //zachariahtimothy.wordpress.com/)
 *
*   @ejemplo
*     $ ( documento ). listo ( función () {
*         $ ( ' #ejemplo ' ). tabla de datos ({
*             " sPaginationType " :  " extStyle "
*         });
*     });
*/

$ . fn . dataTableExt . oApi . fnExtStylePagingInfo  =  function ( oSettings )
{
	volver {
		" iStart " :          oSettings . _iDisplayStart ,
		" iEnd " :            oSettings . fnDisplayEnd (),
		" iLength " :         oSettings . _iDisplayLength ,
		" iTotal " :          oSettings . fnRecordsTotal (),
		" iFilteredTotal " :  oSettings . fnRecordsDisplay (),
		" iPage " :           oSettings . _iDisplayLength  ===  - 1  ?
			0  :  Matemáticas . ceil ( oSettings . _iDisplayStart  /  oSettings . _iDisplayLength ),
		" iTotalPages " :     oSettings . _iDisplayLength  ===  - 1  ?
			0  :  Matemáticas . ceil ( oSettings . fnRecordsDisplay () /  oSettings . _iDisplayLength )
	};
};

$ . fn . dataTableExt . oPaginación . extStyle  = {
    

    " fnInit " :  función ( oSettings , nPaging , fnCallbackDraw ) {
        
        var oPaging =  oSettings . oInstancia . fnExtStylePagingInfo ();

        nFirst =  $ ( ' <span /> ' , { ' class ' :  ' paginate_button first ' , texto :  " << " });
        nPrevious =  $ ( ' <span /> ' , { ' class ' :  ' paginate_button previous ' , texto :  " < " });
        nNext =  $ ( ' <span /> ' , { ' class ' :  ' paginate_button next ' , text :  " > " });
        nLast =  $ ( ' <span /> ' , { ' class ' :  ' paginate_button last ' , texto :  " >> " });
        nPageTxt =  $ ( " <span /> " , {text :  ' Page ' });
        nPageNumBox =  $ ( ' <input /> ' , {type :  ' text ' , val :  1 , ' class ' :  ' pageinate_input_box ' });
        nPageOf =  $ ( ' <span /> ' , {text :  ' / ' });
        nTotalPages =  $ ( ' <span /> ' , {class :   " paginate_total " , text :  oPaging . iTotalPages });

        
        $ (nPaging)
            . añadir (nFirst)
            . añadir (nPrevious)
            . añadir (nPageTxt)
            . añadir (nPageNumBox)
            . añadir (nPageOf)
            . añadir (nTotalPages)
            . append (n La próxima)
            . añadir (nLast);
  
        En primer lugar . haga clic en ( función () {
            if ( $ ( this ). hasClass ( " disabled " ))
                volver ;
            oSettings . oApi . _fnPageChange (oSettings, " first " );
            fnCallbackDraw (oSettings);
        }). bind ( ' selectstart ' , function () { return  false ;});
  
        nPrevious . haga clic en ( función () {
            if ( $ ( this ). hasClass ( " disabled " ))
                volver ;
            oSettings . oApi . _fnPageChange (oSettings, " previous " );
            fnCallbackDraw (oSettings);
        }). bind ( ' selectstart ' , function () { return  false ;});
  
        n La próxima . haga clic en ( función () {
            if ( $ ( this ). hasClass ( " disabled " ))
                volver ;
            oSettings . oApi . _fnPageChange (oSettings, " next " );
            fnCallbackDraw (oSettings);
        }). bind ( ' selectstart ' , function () { return  false ;});
  
        nLast . haga clic en ( función () {
            if ( $ ( this ). hasClass ( " disabled " ))
                volver ;
            oSettings . oApi . _fnPageChange (oSettings, " last " );
            fnCallbackDraw (oSettings);
        }). bind ( ' selectstart ' , function () { return  false ;});
  
        nPageNumBox . cambio ( función () {
            var pageValue =  parseInt ( $ ( this ). val (), 10 ) -  1 ; // -1 porque las páginas están indexadas 0, pero la interfaz de usuario es 1
            var oPaging =  oSettings . oInstancia . fnPagingInfo ();
            
            if (pageValue ===  NaN  || pageValue < 0 ) {
                pageValue =  0 ;
            } else  if (pageValue > =  oPaging . iTotalPages ) {
                pageValue =  oPaging . iTotalPages  - 1 ;
            }
            oSettings . oApi . _fnPageChange (oSettings, pageValue);
            fnCallbackDraw (oSettings);
        });
  
    }
  
  
    " fnUpdate " :  function ( oSettings , fnCallbackDraw ) {
        if ( ! oSettings . aanFeatures . p ) {
            volver ;
        }
        
        var oPaging =  oSettings . oInstancia . fnExtStylePagingInfo ();
  
        / * Bucle sobre cada instancia del buscapersonas * /
        var an =  oSettings . aanFeatures . p ;

        $ (un). buscar ( ' span.paginate_total ' ). html ( oPaging . iTotalPages );
        $ (un). buscar ( ' .pageinate_input_box ' ). val ( oPaging . iPage + 1 );
                
        $ (un). cada ( función ( índice , elemento ) {

            var $ item =  $ (item);
           
            if ( oPaging . iPage  ==  0 ) {
                var prev =  $ item . buscar ( ' span.paginate_button.first ' ). add ( $ item . find ( ' span.paginate_button.previous ' ));
                anterior . addClass ( " deshabilitado " );
            } else {
                var prev =  $ item . buscar ( ' span.paginate_button.first ' ). add ( $ item . find ( ' span.paginate_button.previous ' ));
                anterior . removeClass ( " deshabilitado " );
            }
  
            if ( oPaging . iPage + 1  ==  oPaging . iTotalPages ) {
                var next =  $ item . buscar ( ' span.paginate_button.last ' ). add ( $ item . find ( ' span.paginate_button.next ' ));
                siguiente . addClass ( " deshabilitado " );
            } else {
                var next =  $ item . buscar ( ' span.paginate_button.last ' ). add ( $ item . find ( ' span.paginate_button.next ' ));
                siguiente . removeClass ( " deshabilitado " );
            }
        });
    }
};