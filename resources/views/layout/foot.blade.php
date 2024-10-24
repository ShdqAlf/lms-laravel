<!-- resources/views/foot.blade.php -->
<footer>
    <div class="footer clearfix mb-0 text-muted">
        <div class="float-start">
            <p>2021 &copy; Mazer</p>
        </div>
        <div class="float-end">
            <p>Crafted with <span class="text-danger"><i class="bi bi-heart"></i></span> by <a href="http://ahmadsaugi.com">A. Saugi</a></p>
        </div>
    </div>
</footer>
<script>
    function toggleAccordion(index) {
        const content = document.getElementById(`content-${index}`);
        const icon = document.getElementById(`icon-${index}`);
        if (content.classList.contains('hidden')) {
            content.classList.remove('hidden');
            icon.classList.add('transform', 'rotate-180');
        } else {
            content.classList.add('hidden');
            icon.classList.remove('transform', 'rotate-180');
        }
    }
</script>
<script src="{{ asset('mazer/dist/assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
<script src="{{ asset('mazer/dist/assets/js/bootstrap.bundle.min.js') }}"></script>

<script src="{{ asset('mazer/dist/assets/vendors/apexcharts/apexcharts.js') }}"></script>
<script src="{{ asset('mazer/dist/assets/js/pages/dashboard.js') }}"></script>

<script src="{{ asset('mazer/dist/assets/js/main.js') }}"></script>


</body>

</html>