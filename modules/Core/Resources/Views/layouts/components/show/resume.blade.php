<div class="table-responsive">
    @foreach ($component->meta->tables ?? [] as $i => $tbl)
        @php($_responses = $datadetail[$tbl->id] ?? [])
        @if (count($_responses) > 0)
            <label for="tabel-{{ $i }}" class="px-4 py-4">{{ $tbl->name }}</label>
            <table class="table-resume-{{ $detailkey }} mb-0 table align-middle">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Pertanyaan</th>
                        <th class="text-center">Skor</th>
                        <th class="text-center">Nilai</th>
                        <th class="text-center">Grade</th>
                        <th class="text-center">Deskripsi</th>
                        <th class="text-center">Jawaban</th>
                        <th class="text-center">Bukti</th>
                        <th class="text-center">komentar</th>
                    </tr>
                </thead>
                <tbody class="calc-resume-tbody-{{ $detailkey }}-{{ $i }}">
                    @foreach ($questions->where('table_id', $tbl->id) as $question)
                        @php($detail = $_responses[$question->id] ?? '')
                        @php($score = $detail['score'] ?? '')
                        @php($comment = $detail['comment'] ?? '')
                        @php($evidence = $detail['evidence'] ?? '')
                        <tr class="calc-resume-row-{{ $detailkey }}-{{ $i }}">
                            <td valign="top" width="3%">{{ $loop->iteration }}</td>
                            <td valign="top" width="20%" class="options" data-options="{{ $question->table->outputs }}" data-meta="{{ json_encode($question->meta) }}" data-choice="{{ json_encode($question->options ?? []) }}">
                                <span>{{ $question->name }}</span> (<span class="small text-dark kpi"></span>/<span class="small text-dark target"></span>)
                                <input type="hidden" class="form-control d-none input-kpi text-center" name="resume[detail][{{ $detailkey }}][{{ $tbl->id }}][{{ $question->id }}][kpi]" readonly />
                                <input type="hidden" class="form-control d-none input-target text-center" name="resume[detail][{{ $detailkey }}][{{ $tbl->id }}][{{ $question->id }}][target]" readonly />
                            </td>
                            <td valign="top" width="5%">
                                <input type="text" class="form-control score-{{ $detailkey }}-{{ $i }} bg-transparent text-center" name="resume[detail][{{ $detailkey }}][{{ $tbl->id }}][{{ $question->id }}][score]" value="{{ $score }}" readonly />
                            </td>
                            <td valign="top" width="5%">
                                <input type="text" class="form-control total bg-transparent text-center" name="resume[detail][{{ $detailkey }}][{{ $tbl->id }}][{{ $question->id }}][total_score]" readonly />
                            </td>
                            <td valign="top" width="5%">
                                <input type="text" class="form-control grade bg-transparent text-center" name="resume[detail][{{ $detailkey }}][{{ $tbl->id }}][{{ $question->id }}][grade]" readonly />
                            </td>
                            <td valign="top" width="15%">
                                <textarea class="form-control description bg-transparent" name="resume[detail][{{ $detailkey }}][{{ $tbl->id }}][{{ $question->id }}][description]" id="" rows="2" readonly></textarea>
                            </td>
                            <td valign="top" width="15%">
                                <textarea class="form-control answer bg-transparent" name="resume[detail][{{ $detailkey }}][{{ $tbl->id }}][{{ $question->id }}][answer]" id="" rows="2" readonly></textarea>
                            </td>
                            <td width="15%" valign="top">
                                @php($ev = isset($detail['evidence']) ? explode(',', trim($detail['evidence'], '[]')) : [])
                                <input type="text" class="form-control evidence d-none text-center" name="resume[detail][{{ $detailkey }}][{{ $tbl->id }}][{{ $question->id }}][evidence]" value="{{ json_encode($ev, JSON_UNESCAPED_SLASHES | JSON_NUMERIC_CHECK) }}" readonly />
                                <div class="form-control text-area" contenteditable="false" style="min-height: 63px;">
                                    @if (isset($detail['evidence']))
                                        <ol>
                                            @foreach ($ev as $item)
                                                @if (is_numeric($item))
                                                    <li>{{ $question->evidence[$item] ?? '' }}</li>
                                                @endif
                                            @endforeach
                                        </ol>
                                    @endif
                                </div>
                            </td>
                            <td valign="top" width="15%">
                                <textarea class="form-control comment bg-transparent" name="resume[detail][{{ $detailkey }}][{{ $tbl->id }}][{{ $question->id }}][comment]" id="" rows="2" readonly>{!! $comment !!}</textarea>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
        @endif
    @endforeach
</div>
