 <!-- ============================================================== -->
 <!-- Start Page Content here -->
 <!-- ============================================================== -->

 <div class="content-page">
     <div class="content">

         <!-- Start Content-->
         <div class="container-fluid">

             <div class="row">
                 <div class="col-lg-6">
                     <div class="page-title-box justify-content-between d-flex align-items-lg-center flex-lg-row flex-column">
                         <h4 class="page-title">Alta cotización</h4>
                     </div>
                 </div>
                 <!-- <div class="col-lg-6" style="display: flex; justify-content: center; align-items: center;">
                     <div class="page-title-box justify-content-between d-flex align-items-lg-center flex-lg-row flex-column" style="column-gap: 10px;">
                         <button class="btn btn-warning" type="button" style="font-weight: bold;"><i class="ri-check-line"></i>&nbsp;FINALIZAR</button>
                         <button class="btn btn-success" type="button" style="font-weight: bold;"><i class="ri-attachment-fill"></i>&nbsp;ADJUNTAR EVIDENCIA</button>
                         <button class="btn btn-danger" type="button" style="font-weight: bold;"><i class="ri-close-fill"></i>&nbsp;CANCELAR</button>
                     </div>
                 </div> -->
             </div>

             <div class="card">
                 <div class="card-body">
                     <div class="row">
                         <div class="col-lg-10">
                             <!-- <h4 class="header-title">Floating labels</h4> -->
                             <div class="row">
                                 <div class="col-lg-8 col-md-12">
                                     <div class="input-group flex-nowrap">
                                         <span class="input-group-text" id="basic-addon1"><i class="ri-user-3-fill"></i></span>
                                         <select class="form-select select2" id="cliente" data-toggle="select2" placeholder="seleccionar cliente p/cotizacion...">

                                         </select>
                                         <button class="btn btn-success" type="button"><i class="ri-add-fill" style="font-weight: bold;"></i></button>
                                     </div>
                                 </div>
                                 <div class="col-lg-2 col-md-6">

                                     <div class="mb-3">
                                         <select class="form-select mb-3">
                                             <option value="0">Pesos</option>
                                             <option value="1">Dolares</option>
                                         </select>
                                     </div>
                                 </div>
                                 <div class="col-lg-2 col-md-6 col-xs-12">
                                     <div class="mb-3">
                                         <!-- <label class="form-label">Static</label> -->
                                         <div class="input-group flex-nowrap">
                                             <span class="input-group-text" id="basic-addon1">T.C.</span>
                                             <input type="text" name="bi_pro" id="bi_pro" class="form-control"  placeholder="Buscar por descripcion/clave/tag..." tabindex="4" style="font-size: 12px;" autofocus="true">
                                         </div>
                                     </div>
                                 </div>
                             </div>
                             <div class="row">
                                 <div class="col-lg-8 col-md-12 col-xs-12">
                                     <div class="mb-3">
                                         <div class="input-group">
                                             <input type="text" class="form-control" placeholder="Buscar por descripcion, clave, tag..." aria-label="Recipient's username">
                                             <button class="btn btn-success" type="button"><i class="ri-add-fill" style="font-weight: bold;"></i></button>
                                         </div>
                                     </div>
                                 </div>
                                 <div class="col-lg-2 col-md-6 col-xs-12">
                                     <div class="mb-3">
                                         <input type="number" class="form-control" placeholder="cantidad...">
                                     </div>
                                 </div>
                                 <div class="col-lg-2">
                                     <div class="mb-3">
                                         <p id="unidad" style="font-size: 22px; font-weight: bold;">U.M.</p>
                                     </div>
                                 </div>
                             </div>

                             <div class="row">
                                 <div class="col-lg-10 col-md-12 col-xs-12">
                                     <div class="mb-3">
                                         <textarea class="form-control" id="example-textarea" rows="2" placeholder="Descripcion..."></textarea>
                                     </div>
                                 </div>
                             </div>

                             <div class="row">
                                 <div class="col-lg-2 col-md-6 col-xs-12">
                                     <div class="mb-3">
                                         <input type="text" class="form-control" value="$0" style="text-align: right;">
                                     </div>
                                 </div>
                                 <div class="col-lg-2">
                                     <div class="mb-3">
                                         <div class="input-group flex-nowrap">
                                             <span class="input-group-text" id="basic-addon1" style="color: green; font-weight: bold;">%</span>
                                             <input type="number" class="form-control" placeholder="utilidad..." aria-label="Username" aria-describedby="basic-addon1">
                                         </div>
                                     </div>
                                 </div>
                                 <div class="col-lg-2 col-md-6 col-xs-12">
                                     <div class="mb-3">
                                         <input type="text" class="form-control" placeholder="($)precio..." style="text-align: right;">
                                     </div>
                                 </div>
                                 <div class="col-lg-2">
                                     <div class="mb-3">
                                         <div class="input-group flex-nowrap">
                                             <span class="input-group-text" id="basic-addon1" style="color: red; font-weight: bold;">-%</span>
                                             <input type="number" class="form-control" placeholder="Desc..." aria-label="Username" aria-describedby="basic-addon1">
                                         </div>
                                     </div>
                                 </div>
                                 <div class="col-lg-2 col-md-6 col-xs-12">
                                     <div class="mb-3">
                                         <input type="number" class="form-control" placeholder="($)subtotal..." style="text-align: right;" disabled>
                                     </div>
                                 </div>
                                 <div class="col-lg-2 col-md-6 col-xs-12">
                                     <div class="mb-3">
                                         <button class="btn btn-primary" type="button"><i class="ri-arrow-right-line" style="font-weight: bold;"></i></button>
                                         <button class="btn btn-warning" type="button"><i class="ri-eye-fill"></i></button>
                                     </div>
                                 </div>
                             </div>
                         </div>
                         <div class="col-lg-2" style="text-align: center;">
                             <div class="row">
                                 <div class="mb-3">
                                     <a href="#" style="color: green; font-size: 11px;">(Ver detalles)</a>
                                     <br><br>
                                     <p style="color: green;">Subtotal: $0</p>
                                     <h3 style="color: green; font-weight: bold;">Total: $0</h3>
                                 </div>
                             </div>
                         </div>
                     </div>
                 </div>
                 <div class="card-body">
                     <div class="row">
                         <div class="col-lg-12">
                             <div class="card">
                                 <div class="card-body">

                                     <table id="scroll-horizontal-datatable" class="table table-striped w-100 nowrap">
                                         <thead>
                                             <tr style="background-color: #505050;">
                                                 <th style="color: white; font-weight: bold;">Acciones</th>
                                                 <th style="color: white; font-weight: bold;">No.</th>
                                                 <th style="color: white; font-weight: bold;">Canidad</th>
                                                 <th style="color: white; font-weight: bold;">Clave</th>
                                                 <th style="color: white; font-weight: bold;">Descripción</th>
                                                 <th style="color: white; font-weight: bold;">UM</th>
                                                 <th style="color: white; font-weight: bold;">Precio</th>
                                                 <th style="color: white; font-weight: bold;">Iva(%)</th>
                                                 <th style="color: white; font-weight: bold;">Desc(%)</th>
                                                 <th style="color: white; font-weight: bold;">UTL(%)</th>
                                                 <th style="color: white; font-weight: bold;">TC.</th>
                                                 <th style="color: white; font-weight: bold;">Subtotal</th>
                                             </tr>
                                         </thead>
                                         <tbody>
                                             <!-- <tr>
                                                         <td>Tiger</td>
                                                         <td>Nixon</td>
                                                         <td>System Architect</td>
                                                         <td>Edinburgh</td>
                                                         <td>61</td>
                                                         <td>2011/04/25</td>
                                                         <td>$320,800</td>
                                                         <td>5421</td>
                                                         <td>t.nixon@datatables.net</td>
                                                     </tr>
                                                     <tr>
                                                         <td>Garrett</td>
                                                         <td>Winters</td>
                                                         <td>Accountant</td>
                                                         <td>Tokyo</td>
                                                         <td>63</td>
                                                         <td>2011/07/25</td>
                                                         <td>$170,750</td>
                                                         <td>8422</td>
                                                         <td>g.winters@datatables.net</td>
                                                     </tr>
                                                     <tr>
                                                         <td>Ashton</td>
                                                         <td>Cox</td>
                                                         <td>Junior Technical Author</td>
                                                         <td>San Francisco</td>
                                                         <td>66</td>
                                                         <td>2009/01/12</td>
                                                         <td>$86,000</td>
                                                         <td>1562</td>
                                                         <td>a.cox@datatables.net</td>
                                                     </tr>
                                                     <tr>
                                                         <td>Cedric</td>
                                                         <td>Kelly</td>
                                                         <td>Senior Javascript Developer</td>
                                                         <td>Edinburgh</td>
                                                         <td>22</td>
                                                         <td>2012/03/29</td>
                                                         <td>$433,060</td>
                                                         <td>6224</td>
                                                         <td>c.kelly@datatables.net</td>
                                                     </tr>
                                                     <tr>
                                                         <td>Airi</td>
                                                         <td>Satou</td>
                                                         <td>Accountant</td>
                                                         <td>Tokyo</td>
                                                         <td>33</td>
                                                         <td>2008/11/28</td>
                                                         <td>$162,700</td>
                                                         <td>5407</td>
                                                         <td>a.satou@datatables.net</td>
                                                     </tr>
                                                     <tr>
                                                         <td>Brielle</td>
                                                         <td>Williamson</td>
                                                         <td>Integration Specialist</td>
                                                         <td>New York</td>
                                                         <td>61</td>
                                                         <td>2012/12/02</td>
                                                         <td>$372,000</td>
                                                         <td>4804</td>
                                                         <td>b.williamson@datatables.net</td>
                                                     </tr>
                                                     <tr>
                                                         <td>Herrod</td>
                                                         <td>Chandler</td>
                                                         <td>Sales Assistant</td>
                                                         <td>San Francisco</td>
                                                         <td>59</td>
                                                         <td>2012/08/06</td>
                                                         <td>$137,500</td>
                                                         <td>9608</td>
                                                         <td>h.chandler@datatables.net</td>
                                                     </tr>
                                                     <tr>
                                                         <td>Rhona</td>
                                                         <td>Davidson</td>
                                                         <td>Integration Specialist</td>
                                                         <td>Tokyo</td>
                                                         <td>55</td>
                                                         <td>2010/10/14</td>
                                                         <td>$327,900</td>
                                                         <td>6200</td>
                                                         <td>r.davidson@datatables.net</td>
                                                     </tr>
                                                     <tr>
                                                         <td>Colleen</td>
                                                         <td>Hurst</td>
                                                         <td>Javascript Developer</td>
                                                         <td>San Francisco</td>
                                                         <td>39</td>
                                                         <td>2009/09/15</td>
                                                         <td>$205,500</td>
                                                         <td>2360</td>
                                                         <td>c.hurst@datatables.net</td>
                                                     </tr>
                                                     <tr>
                                                         <td>Sonya</td>
                                                         <td>Frost</td>
                                                         <td>Software Engineer</td>
                                                         <td>Edinburgh</td>
                                                         <td>23</td>
                                                         <td>2008/12/13</td>
                                                         <td>$103,600</td>
                                                         <td>1667</td>
                                                         <td>s.frost@datatables.net</td>
                                                     </tr>
                                                     <tr>
                                                         <td>Jena</td>
                                                         <td>Gaines</td>
                                                         <td>Office Manager</td>
                                                         <td>London</td>
                                                         <td>30</td>
                                                         <td>2008/12/19</td>
                                                         <td>$90,560</td>
                                                         <td>3814</td>
                                                         <td>j.gaines@datatables.net</td>
                                                     </tr>
                                                     <tr>
                                                         <td>Quinn</td>
                                                         <td>Flynn</td>
                                                         <td>Support Lead</td>
                                                         <td>Edinburgh</td>
                                                         <td>22</td>
                                                         <td>2013/03/03</td>
                                                         <td>$342,000</td>
                                                         <td>9497</td>
                                                         <td>q.flynn@datatables.net</td>
                                                     </tr>
                                                     <tr>
                                                         <td>Charde</td>
                                                         <td>Marshall</td>
                                                         <td>Regional Director</td>
                                                         <td>San Francisco</td>
                                                         <td>36</td>
                                                         <td>2008/10/16</td>
                                                         <td>$470,600</td>
                                                         <td>6741</td>
                                                         <td>c.marshall@datatables.net</td>
                                                     </tr>
                                                     <tr>
                                                         <td>Haley</td>
                                                         <td>Kennedy</td>
                                                         <td>Senior Marketing Designer</td>
                                                         <td>London</td>
                                                         <td>43</td>
                                                         <td>2012/12/18</td>
                                                         <td>$313,500</td>
                                                         <td>3597</td>
                                                         <td>h.kennedy@datatables.net</td>
                                                     </tr> -->
                                         </tbody>
                                     </table>

                                 </div> <!-- end card body-->
                             </div> <!-- end card -->
                         </div><!-- end col-->
                     </div>
                 </div>
             </div>