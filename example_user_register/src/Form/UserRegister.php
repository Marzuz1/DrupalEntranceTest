<?php

namespace Drupal\example_user_register\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Database\Database;
/**
 * Class UserRegister.
 */
class UserRegister extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'user_register';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['fullname'] = [
      '#type' =>'textfield',
      '#title' => $this->t('Full Name'),
      '#required' => TRUE,
      '#description' => $this->t('Please enter your Full Name')
    ];
    
    $form['phonenumber'] = [
      '#type' =>'tel',
      '#title' => $this->t('PhoneNumber'),
      '#required' => TRUE,
      '#description' => $this->t('Please enter your PhoneNumber')
    ];    
    $form['email'] = [
      '#type' =>'email',
      '#title' => $this->t('Email'),
      '#required' => TRUE,
      '#description' => $this->t('Please enter your Email')
    ];
    
   $form['ages'] = [
      '#title' =>$this-> t('Ages'),
      '#type' => 'select',
      '#description' => "Select your Age",
      '#options' => [
        t('10-20')->render() => [
          '10' => t('10'),
          '11' => t('11'),
          '12' => t('12'),
          '13' => t('13'),
          '14' => t('14'),
          '15' => t('15'),
          '16' => t('16'),
          '17' => t('17'),
          '18' => t('18'),
          '19' => t('19'),
          '20' => t('20')
        ],
         t('21-30')->render() => [
          '21' => t('21'),
          '22' => t('22'),
          '23' => t('23'),
          '24' => t('24'),
          '25' => t('25'),
          '26' => t('26'),
          '27' => t('27'),
          '28' => t('28'),
          '29' => t('29'),
          '30' => t('30')
         ],
         t('31-50')->render() => [
          '31' => t('31'),
          '32' => t('32'),
          '33' => t('33'),
          '34' => t('34'),
          '35' => t('35'),
          '36' => t('36'),
          '37' => t('37'),
          '38' => t('38'),
          '39' => t('39'),
          '40' => t('40'),
          '41' => t('41'),
          '42' => t('42'),
          '43' => t('43'),
          '44' => t('44'),
          '45' => t('45'),
          '46' => t('46'),
          '47' => t('47'),
          '48' => t('48'),
          '49' => t('49'),
          '50' => t('50')
         ]
      ]
         ];

         $form['aboutme'] = [
          '#type' =>'textarea',
          '#title' => $this->t('About Me'),
          '#description' => $this->t('Please introduce yourself')
        ];
    
    
    
    
    $form['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Submit'),
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    if($form_state->getValue('ages') < 18){
      $form_state->setErrorByName(
        'ages',
        $this->t('You must be over 18 to register ;)')
      );
    }
    //regrex pattern for email return 1 if match
    $str = $form_state->getValue('email');
    $pattern = "/^[\w.+\-]+@kyanon\.digital$/i";
    if(preg_match($pattern, $str) < 1){
      $form_state->setErrorByName(
        'Email',
        $this->t('Your Mail isnt belong to @kyanon.digital, please try again')
      );
    }
    //regrex pattern for phonenumber return 1 if match
    $sdt = $form_state->getValue('phonenumber');
    $patternsdt = "/(84|0[3|5|7|8|9])+([0-9]{8})\b/i";
    if(preg_match($patternsdt, $sdt) < 1){
      $form_state->setErrorByName(
        'Phone',
        $this->t('Your PhoneNumber must be Vietnamese PhoneNumber')
      );
    }



  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // Display result.
    //foreach ($form_state->getValues() as $key => $value) {
      //\Drupal::messenger()->addMessage($key . ': ' . ($key === 'text_format'?$value['value']:$value));
    //}
    $postData = $form_state->getValues();

    /**
     * remove unwanted keys form $postData
     */
    unset($postData['submit'],$postData['form_build_id'],$postData['form_token'],$postData['form_id'],$postData['op']);

    //Query data
    $query = \Drupal::database();
    //insert data to dp_user
    $query->insert('user')->fields($postData)->execute();
    \Drupal::messenger()->addMessage($this->t('successfully!'),'status');



  }

}
