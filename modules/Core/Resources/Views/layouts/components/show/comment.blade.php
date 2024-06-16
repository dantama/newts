<div class="card-body">
    <div class="tab-content mt-2">
        @if ($responses->count() > 0)
            <div class="table-responsive">
                <table class="mb-0 table align-middle">
                    <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th>Responden</th>
                            @foreach ($questions as $label => $_questions)
                                @foreach ($_questions as $question)
                                    <th>{{ $question->name }}</th>
                                @endforeach
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($responses as $uid => $value)
                            <tr>
                                <td class="text-center" width="3%">{{ $loop->iteration }}</td>
                                <td width="20%">{{ \Modules\Account\Models\Employee::with('user')->find($uid)->user->name }}</td>
                                @foreach ($questions as $label => $_questions)
                                    @foreach ($_questions as $question)
                                        @php($data = $value->firstWhere('question_id', $question->id))
                                        <td>
                                            <textarea class="form-control" rows="1" name="resume[detail][{{ $uid }}][{{ $question->id }}][description]">{{ $data->score ?? $data->meta?->description }}</textarea>
                                        </td>
                                    @endforeach
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
