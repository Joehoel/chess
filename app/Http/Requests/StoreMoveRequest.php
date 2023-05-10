<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMoveRequest extends FormRequest
{
	/**
	 * Determine if the user is authorized to make this request.
	 */
	public function authorize(): bool
	{
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
	 */
	public function rules(): array
	{
		return [
			'from' => [
				'string',
				'required',
				'max:2',
				// TODO add also check on possible moves key.
			],
			'to' => [
				'string',
				'required',
				'max:2',
				'different:from',
				'in_array:possible_moves'
			],
			'possible_moves' => [
				'required',
				'array'
			]
		];
	}

	public function messages(): array
	{
		return [
			// TODO check if the overrule notation with * is correct
			'possible_moves.array' => 'Geen beschikbare zet',
			'from.*' => 'Geen geldige zet.',
			'to.*' => 'Geen geldige zet.',
			'possible_moves.*' => 'Geen beschikbare zet',
		];
	}
}
