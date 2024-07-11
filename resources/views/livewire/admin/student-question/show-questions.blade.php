<div class="card p-5">
    <h1 class="mb-3">Student Questions</h1>
    <table class="table p-3">
        <thead>
            <tr>
                <th>Content</th>
                <th>Student</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($questions as $question)
                <tr>
                    <td>{{ $question->content }}</td>
                    <td>{{ $question->user->name }}</td>
                    <td>
                        <a href="{{ route('answer-question', ['questionId' => $question->id]) }}" class="btn btn-primary">Answer</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
