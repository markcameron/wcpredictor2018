<?php namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubmitPredictionRequest extends FormRequest {

  /**
   * Determine if the user is authorized to make this request.
   *
   * @return bool
   */
  public function authorize() {
    return true;
  }

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function rules() {
    return [
      'score_home' => 'required|integer|between:0,20',
      'score_away' => 'required|integer|between:0,20',
    ];
  }

}
