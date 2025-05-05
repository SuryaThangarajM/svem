<div class="d-flex flex-column align-items-center mt-3">
    <!-- Visible on mobile only -->
    <p class="text-muted text-center d-md-none">
        Showing {{ $expall->firstItem() }} to {{ $expall->lastItem() }} of {{ $expall->total() }} results
    </p>
    <div class="table-responsive">
        {{ $expall->links('pagination::bootstrap-5') }}
    </div>
    <!-- Visible on desktop only -->
    <p class="text-muted text-center d-none d-md-block">
        Showing {{ $expall->firstItem() }} to {{ $expall->lastItem() }} of {{ $expall->total() }} results
    </p>
</div>  