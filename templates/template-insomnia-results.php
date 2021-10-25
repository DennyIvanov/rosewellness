<?php
/**
 * Template Name: Insomnia Result Summary
 * Description: A Page Template that display portfolio items.
 *
 * @package Betheme
 * @author Muffin Group
 */

get_header();

// Post Meta
$post_id = get_the_ID();

// Get Threshold Data
$threshold_message = get_post_meta($post_id, 'insomnia_threshold_message', true);
$banner_image_url_src = wp_get_attachment_image_src($threshold_message['post_cta_bg_img'], 'full');


// WP Forms Entry ID
$entry_id = @$_GET['success'];

// Get the full entry object
$entry = wpforms()->entry->get( $entry_id );

// Fields are in JSON, so we decode to an array
$entry_fields = json_decode( $entry->fields, true );


// Threshold Score
$threshold_level_score_1 = $threshold_message['head_threshold_level_score_1'];
$threshold_level_score_2 = $threshold_message['head_threshold_level_score_2'];
$threshold_level_score_3 = $threshold_message['head_threshold_level_score_3'];
$threshold_level_score_4 = $threshold_message['head_threshold_level_score_4'];


// SalesForce API

$client_key = '3MVG9szVa2RxsqBakjwNOHMIqqZ5zUOhCGA4w0euVN.JVvM7HuDdHd0B.CasuYhU5j.13tZ83_gEN5bR..n28';
$client_secret = 'D1D6FE3C469C84A6A09925733733B3D6EE4D111BE487C71A14A85A592F5AE3ED';
$callback = home_url('salesforce-api-callback/');

$tokens = json_decode(get_option('salesforce_token'));
$refresh_token = $tokens->refresh_token;

$endpoint = 'https://login.salesforce.com/services/oauth2/token?grant_type=refresh_token&client_id=' . $client_key . '&client_secret=' . $client_secret . '&refresh_token=' . $refresh_token;
$ch = @curl_init();
@curl_setopt($ch, CURLOPT_POST, true);
@curl_setopt($ch, CURLOPT_URL, $endpoint);
@curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = @curl_exec($ch);
@curl_close($ch);

$new_tokens = json_decode($response);

$access_tokens = $new_tokens->access_token;
$instance = $new_tokens->instance_url;

// Submission details
$dob_f = date('Y-m-d', strtotime($dob));
$patient_details = array( 
	'Patient_Name__c' => $entry_fields[86]['value'] . ' ' . $entry_fields[114]['value'],
	'FirstName' => $entry_fields[86]['value'],
	'LastName' => $entry_fields[114]['value'],
	'Email' => $entry_fields[87]['value'],
	'Phone' => $entry_fields[88]['value'],
	'Company' => '1',
	'Interests__c' => 'Sleep',
    'Secondary_Health_Concern__c' => 'Functional Medicine',
	'Residency_State__c' => $entry_fields[165]['value'],
	'LeadSource' => 'Insomnia Quiz - RW',
	'Total_Score__c' => $entry_fields[90]['value']
);
$patient_details = json_encode($patient_details);

$endpoint = $instance . '/services/data/v20.0/sobjects/Lead';

$ch = @curl_init();
@curl_setopt($ch, CURLOPT_POST, true);
@curl_setopt($ch, CURLOPT_POSTFIELDS, $patient_details);
@curl_setopt($ch, CURLOPT_URL, $endpoint);
@curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			'Content-Type: application/json',
			'Authorization: Bearer ' . $access_tokens
		));
@curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = @curl_exec($ch);
@curl_close($ch);

$patient_response = json_decode($response);
$patient_id = $patient_response->id;

?>
        
	    <div class="top_banner_single" style="background-image:url('<?php echo $banner_image_url_src[0]; ?>')">
        </div>

        <div class="full-width-page-content">
            <div class="container">
			
				<?php
                if (have_posts()): while (have_posts()): the_post();
                        the_content();
                    endwhile;
                endif;
                ?>
				
				<div class="thank_you_message orange_box">
					<?php echo $threshold_message['subheading_text']; ?>
				</div>
				
				<div class="thank_you_message grey_box immune_score">
					<p class="score_result"><strong>Survey Total Score</strong> <span><?php echo $entry_fields[90]['value']; ?></span></p>
					<?php
						
						if($entry_fields[90]['value'] <= 7) {
							
							echo '<p>'.$threshold_message['threshold_level_1_message'].'</p>';
							
						} else if(($entry_fields[90]['value'] >= 8) && ($entry_fields[90]['value'] <= 14)) {
							
							echo '<p>'.$threshold_message['threshold_level_2_message'].'</p>';
							
						} else if(($entry_fields[90]['value'] >= 15) && ($entry_fields[90]['value'] <= 21)) {
							
							echo '<p>'.$threshold_message['threshold_level_3_message'].'</p>';
							
							if($patient_response->success == 1) {
								echo 'Thank you for your interest in seeking help for your Sleep Disorders. Our wellness coordinator will get in touch soon!';
							} else {
							echo '<a href="https://www.rosewellness.com/insomnia-assessment-results/?success='.$entry_id.'&submit=lead">Click here for help with your Sleep Disorder</a>';
							}
							
						} else {
							
							echo '<p>'.$threshold_message['threshold_level_4_message'].'</p>';
							//if($patient_response->success == 1) {
							echo 'Thank you for your interest in seeking help for your Sleep Disorders. Our wellness coordinator will get in touch soon!';
							//} else {
							///	echo '<a href="https://www.rosewellness.com/insomnia-assessment-results/?success='.$entry_id.'&submit=lead">Click here for help with your Sleep Disorder</a>';
							//}
						}
					?>
				</div>
			</div>
		</div>

<?php get_footer();