    <!-- Hidden Delete Form -->
    <form x-ref="deleteForm" method="POST" class="hidden">
        @csrf
        @method('DELETE')
    </form>
