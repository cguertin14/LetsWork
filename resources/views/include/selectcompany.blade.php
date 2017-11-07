<script>
    function selectCompany(companySlug) {
        $.post({
            url: '{{url('/company')}}/' + companySlug + '/select',
            data: { slug: companySlug, _token: "{{ csrf_token() }}" },
            success: function () {
                location.reload();
            }
        });
    }
</script>