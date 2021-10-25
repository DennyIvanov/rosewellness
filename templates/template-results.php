<?php
/**
 * Template Name: Health Result Summary
 * Description: A Page Template that display portfolio items.
 *
 * @package Betheme
 * @author Muffin Group
 */

get_header();

// Post Meta
$post_id = get_the_ID();

// Get Threshold Data
$threshold_message = get_post_meta($post_id, 'threshold_message', true);
$banner_image_url_src = wp_get_attachment_image_src($threshold_message['post_cta_bg_img'], 'full');

// WP Forms Entry ID
$entry_id = @$_GET['success'];

// Get the full entry object
$entry = wpforms()->entry->get( $entry_id );

// Fields are in JSON, so we decode to an array
$entry_fields = json_decode( $entry->fields, true );


// Threshold Score
$immune_threshold_level_score_1 = $threshold_message['immune_threshold_level_score_1'];
$immune_threshold_level_score_2 = $threshold_message['immune_threshold_level_score_2'];

$gut_threshold_level_score_1 = $threshold_message['gut_threshold_level_score_1'];
$gut_threshold_level_score_2 = $threshold_message['gut_threshold_level_score_2'];

$thyroid_threshold_level_score_1 = $threshold_message['thyroid_threshold_level_score_1'];
$thyroid_threshold_level_score_2 = $threshold_message['thyroid_threshold_level_score_2'];

$adrenal_threshold_level_score_1 = $threshold_message['adrenal_threshold_level_score_1'];
$adrenal_threshold_level_score_2 = $threshold_message['adrenal_threshold_level_score_2'];

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
	'Interests__c' => $entry_fields[160]['value'],
	'LeadSource' => 'Health Check Quiz - RW',
    'Secondary_Health_Concern__c' => 'Functional Medicine',
	'Residency_State__c' => $entry_fields[159]['value'],
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
        
		<!-- .sections_group -->
		<div class="full-width-page-content">
            <div class="container">
			
				<?php
                if (have_posts()): while (have_posts()): the_post();
                        the_content();
                    endwhile;
                endif;
                ?>
				

				<div class="thank_you_message orange_box">
					<p><strong>Thank you for completing the <strong>Health Check Quiz</strong> and learning more about your health. Here is a brief summray of your results.</p>
					<p class="score_result"><strong>Survey Total Score</strong> <span><?php echo $entry_fields[90]['value']; ?></span></p>
				</div>
				
				<div class="thank_you_message grey_box immune_score">
					<p class="score_result"><strong>Immune Health Score</strong> <span><?php echo $entry_fields[92]['value']; ?></span></p>
					<?php
						
						if($entry_fields[92]['value'] > $immune_threshold_level_score_2) {
							
							echo '<p>'.$threshold_message['immune_threshold_level_2'].'</p>';
							
						} else if($entry_fields[92]['value'] > $immune_threshold_level_score_1) {
							
							echo '<p>'.$threshold_message['immune_threshold_level_1'].'</p>';
							
						} else {
							
							echo '<p>'.$threshold_message['immune_threshold_level_0'].'</p>';
							
						}
						
					?>
				</div>
				
				<div class="thank_you_message grey_box gut_score">
					<p class="score_result"><strong>Gut Health Score</strong> <span><?php echo $entry_fields[93]['value']; ?></span></p>
					<?php
						
						if($entry_fields[93]['value'] > $gut_threshold_level_score_2) {
							
							echo '<p>'.$threshold_message['gut_threshold_level_2'].'</p>';
							
						} else if($entry_fields[93]['value'] > $gut_threshold_level_score_1) {
							
							echo '<p>'.$threshold_message['gut_threshold_level_1'].'</p>';
							
						} else {
							
							echo '<p>'.$threshold_message['gut_threshold_level_0'].'</p>';
							
						}
						
					?>
				</div>
				
				<div class="thank_you_message grey_box thyroid_score">
					<p class="score_result"><strong>Thyroid Health Score</strong> <span><?php echo $entry_fields[94]['value']; ?></span></p>
					<?php
						
						if($entry_fields[94]['value'] > $thyroid_threshold_level_score_2) {
							
							echo '<p>'.$threshold_message['thyroid_threshold_level_2'].'</p>';
							
						} else if($entry_fields[94]['value'] > $thyroid_threshold_level_score_1) {
							
							echo '<p>'.$threshold_message['thyroid_threshold_level_1'].'</p>';
							
						} else {
							
							echo '<p>'.$threshold_message['thyroid_threshold_level_0'].'</p>';
							
						}
						
					?>
				</div>
				
				<div class="thank_you_message grey_box adrenal_score">
					<p class="score_result"><strong>Adrenal Health Score</strong> <span><?php echo $entry_fields[95]['value']; ?></span></p>
					<?php
						
						if($entry_fields[95]['value'] > $adrenal_threshold_level_score_2) {
							
							echo '<p>'.$threshold_message['adrenal_threshold_level_2'].'</p>';
							
						} else if($entry_fields[95]['value'] > $adrenal_threshold_level_score_1) {
							
							echo '<p>'.$threshold_message['adrenal_threshold_level_1'].'</p>';
							
						} else {
							
							echo '<p>'.$threshold_message['adrenal_threshold_level_0'].'</p>';
							
						}
						
					?>
				</div>
			</div>
		</div>
		
<?php get_footer();

// Omit Closing PHP Tags