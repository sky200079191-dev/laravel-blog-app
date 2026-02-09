<div class="mt-2">
    <form action="{{ route('posts.like', $post) }}" method="POST" style="display: inline;">
        @csrf
        <input type="hidden" name="is_good" value="1">
        <button type="submit" class="btn btn-sm btn-outline-primary">
            👍 {{ $post->likes()->where('is_good', true)->count() }}
        </button>
    </form>

    <form action="{{ route('posts.like', $post) }}" method="POST" style="display: inline;">
        @csrf
        <input type="hidden" name="is_good" value="0">
        <button type="submit" class="btn btn-sm btn-outline-danger">
            👎 {{ $post->likes()->where('is_good', false)->count() }}
        </button>
    </form>
</div>