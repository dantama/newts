<div class="table-responsive">
    @foreach ($component->meta->tables ?? [] as $i => $tbl)
        @php($_responses = $responses[$tbl->id][$v->empl_id] ?? [])
        @if (count($_responses) > 0)
            <label for="tabel-{{ $i }}" class="px-4 py-4">{{ $tbl->name }}</label>
            <table class="table-resume-{{ $v->empl_id }} mb-0 table align-middle">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Pertanyaan</th>
                        <th class="d-none d-lg-table-cell text-center">Skor</th>
                        <th class="text-center">Nilai</th>
                        <th class="text-center">Grade</th>
                        <th class="text-center">Deskripsi</th>
                        <th class="d-none d-lg-table-cell text-center">Jawaban</th>
                        <th class="d-none d-lg-table-cell text-center">Bukti</th>
                        <th class="text-center">komentar</th>
                    </tr>
                </thead>
                <tbody class="calc-resume-tbody-{{ $v->empl_id }}-{{ $i }}">
                    @foreach ($questions->where('table_id', $tbl->id) as $question)
                        @php($data = $_responses->firstWhere('question_id', $question->id))
                        @php($score = isset($data) ? $data->score : '')
                        @php($comment = isset($data) ? $data->meta?->description : '')
                        @php($evidence = isset($data) ? $data->meta?->evidence : '')
                        <tr class="calc-resume-row-{{ $v->empl_id }}-{{ $i }}">
                            <td width="3%" valign="top">{{ $loop->iteration }}</td>
                            <td width="20%" class="options" valign="top" data-options="{{ $question->table->outputs }}" data-meta="{{ json_encode($question->meta) }}" data-choice="{{ json_encode($question->options ?? []) }}" data-evidence="{{ json_encode($question->evidence ?? []) }}">
                                <span>{{ $question->name }}</span> (<span class="small text-dark kpi"></span>/<span class="small text-dark target"></span>)
                                <input type="hidden" class="form-control d-none input-kpi text-center" name="resume[detail][{{ $v->empl_id }}][{{ $tbl->id }}][{{ $question->id }}][kpi]" readonly />
                                <input type="hidden" class="form-control d-none input-target text-center" name="resume[detail][{{ $v->empl_id }}][{{ $tbl->id }}][{{ $question->id }}][target]" readonly />
                            </td>
                            <td width="5%" valign="top" class="d-none d-lg-table-cell">
                                <input type="text" class="form-control score-{{ $v->empl_id }}-{{ $i }} bg-transparent text-center" name="resume[detail][{{ $v->empl_id }}][{{ $tbl->id }}][{{ $question->id }}][score]" value="{{ $score }}" readonly />
                            </td>
                            <td width="5%" valign="top">
                                <input type="text" class="form-control total bg-transparent text-center" name="resume[detail][{{ $v->empl_id }}][{{ $tbl->id }}][{{ $question->id }}][total_score]" readonly />
                            </td>
                            <td width="5%" valign="top">
                                <input type="text" class="form-control grade bg-transparent text-center" name="resume[detail][{{ $v->empl_id }}][{{ $tbl->id }}][{{ $question->id }}][grade]" readonly />
                            </td>
                            <td width="15%" valign="top">
                                <textarea class="form-control description mb-2 bg-transparent" name="resume[detail][{{ $v->empl_id }}][{{ $tbl->id }}][{{ $question->id }}][description]" id="" rows="2" readonly></textarea>
                            </td>
                            <td width="15%" valign="top" class="d-none d-lg-table-cell">
                                <textarea class="form-control answer mb-2 bg-transparent" name="resume[detail][{{ $v->empl_id }}][{{ $tbl->id }}][{{ $question->id }}][answer]" id="" rows="2" readonly></textarea>
                            </td>
                            <td width="15%" valign="top" class="d-none d-lg-table-cell">
                                <input type="text" class="form-control d-none evidence text-center" name="resume[detail][{{ $v->empl_id }}][{{ $tbl->id }}][{{ $question->id }}][evidence]" value="{{ json_encode($evidence, JSON_UNESCAPED_SLASHES | JSON_NUMERIC_CHECK) }}" readonly />
                                <div class="form-control text-area" contenteditable="false">
                                    @if (isset($evidence))
                                        <ol>
                                            @foreach (collect($evidence) as $item)
                                                @if (is_numeric($item))
                                                    <li>{{ $question->evidence[$item] ?? '' }}</li>
                                                @endif
                                            @endforeach
                                        </ol>
                                    @endif
                                </div>
                            </td>
                            <td width="15%" valign="top">
                                <textarea class="form-control comment bg-transparent" name="resume[detail][{{ $v->empl_id }}][{{ $tbl->id }}][{{ $question->id }}][comment]" id="" rows="2" readonly>{!! $comment !!}</textarea>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    @endforeach
</div>

@push('styles')
    <style>
        .text-area {
            -moz-appearance: textfield-multiline;
            -webkit-appearance: textarea;
            overflow: auto;
            padding: 2px;
            resize: both;
        }
    </style>
@endpush
