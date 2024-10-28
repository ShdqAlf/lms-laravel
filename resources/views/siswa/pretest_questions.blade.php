<div class="container">
    <h3 class="mb-4">Pretest</h3>
    <form action="{{ route('storeAnswers') }}" method="POST">
        @csrf
        @foreach($questions as $question)
        <div class="mb-4">
            <h5>{{ $question->soal_pretest }}</h5>
            <input type="text" name="jawaban[{{ $question->id }}]" class="form-control" placeholder="Masukkan jawaban Anda" required>
        </div>
        @endforeach
        <button type="submit" class="btn btn-primary">Simpan Jawaban</button>
    </form>
</div>