<footer>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 col-md-6 col-xl-6 footer-copyright">
                <p class="mb-0"> {{date("Y")}} © All Rights Reserved  <a href=""></a></p>
            </div>
            <div class="col-sm-12  col-md-6 col-xl-6">
                <ul class="footer-links">
                    <li><a href="">{{session('sucursal')}}</a></li>
                    <li><a href="">{{session("rol")}}</a></li>
                </ul>
            </div>
        </div>
    </div>
</footer>