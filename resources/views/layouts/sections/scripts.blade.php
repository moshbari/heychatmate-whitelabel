<!-- BEGIN: Vendor JS-->
<script src="{{ asset(mix('assets/vendor/libs/jquery/jquery.js')) }}"></script>
<script src="{{ asset(mix('assets/vendor/libs/popper/popper.js')) }}"></script>
<script src="{{ asset(mix('assets/vendor/js/bootstrap.js')) }}"></script>
<script src="{{ asset(mix('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js')) }}"></script>
<script src="{{ asset(mix('assets/vendor/js/menu.js')) }}"></script>
@yield('vendor-script')
<!-- END: Page Vendor JS-->
<!-- BEGIN: Theme JS-->
<script src="{{ asset(mix('assets/js/main.js')) }}"></script>
<script src="https://cdn.jsdelivr.net/npm/typed.js@2.0.12"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.2/dist/sweetalert2.all.min.js"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
<script>
    $(function() {
        var availableTags = [
            @foreach (array_slice($menuData[0]->menu, 1) as $menu)
                {
                    "label": "{{ $menu->name }}",
                    "url": "{{ url($menu->url) }}"
                },
            @endforeach
        ];
        $("#tagsdd").autocomplete({
            source: availableTags,
            appendTo: ".slists",
            select: function(event, ui) {
                console.log(ui.item.url)
                window.location = ui.item.url
            }
        });
    });
</script>
<!-- END: Theme JS-->
<!-- Pricing Modal JS-->
@stack('pricing-script')
<!-- END: Pricing Modal JS-->
<!-- BEGIN: Page JS-->
@yield('page-script')
<!-- END: Page JS-->
