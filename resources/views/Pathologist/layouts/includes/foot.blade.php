<!-- Start JS -->
<script src="{{ asset('assets/center-part/js/bootstrap.bundle.min.js') }}"></script>
<!-- End JS -->

<script src="{{ asset('assets/helper.js') }}"></script>

<script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
@include('sweetalert::alert')
{{-- @include('Others.sweetalert-js'); --}}

@stack('datatableJS')

<script src="{{ asset('assets/super-admin/js/app.js') }}"></script>

@stack('script')