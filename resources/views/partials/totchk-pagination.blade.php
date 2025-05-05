<div class="d-flex flex-column align-items-center mt-3">
    <!-- Visible on mobile only -->
    <p class="text-muted text-center d-md-none">
        Showing {{ $billall->firstItem() }} to {{ $billall->lastItem() }} of {{ $billall->total() }} results
    </p>
    <div class="table-responsive">
        {{ $billall->links('pagination::bootstrap-5') }}
    </div>
    <!-- Visible on desktop only -->
    <p class="text-muted text-center d-none d-md-block">
        Showing {{ $billall->firstItem() }} to {{ $billall->lastItem() }} of {{ $billall->total() }} results
    </p>
</div>  