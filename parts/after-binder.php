<footer class="main-footer-af">
		<address itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">
			<meta itemprop="name" content="<?php echo esc_attr( spine_get_option( 'contact_name' ) ); ?>">
	<meta itemprop="department" content="<?php echo esc_attr( spine_get_option( 'contact_department' ) ); ?>">
		<?php echo esc_attr( spine_get_option( 'contact_department' ) ); ?><br />
		<meta itemprop="streetAddress" content="<?php echo esc_attr( spine_get_option( 'contact_streetAddress' ) ); ?>">
		<?php echo esc_attr( spine_get_option( 'contact_streetAddress' ) ); ?><br />
		<meta itemprop="addressLocality" content="<?php echo esc_attr( spine_get_option( 'contact_addressLocality' ) ); ?>">
		<?php echo esc_attr( spine_get_option( 'contact_addressLocality' ) ); ?><br />
		<meta itemprop="postalCode" content="<?php echo esc_attr( spine_get_option( 'contact_postalCode' ) ); ?>">

	<meta itemprop="telephone" content="<?php echo esc_attr( spine_get_option( 'contact_telephone' ) ); ?>">
	<?php echo esc_attr( spine_get_option( 'contact_telephone' ) ); ?><br />
	<meta itemprop="email" content="<?php echo esc_attr( spine_get_option( 'contact_email' ) ); ?>">
	<a href="mailto:<?php echo esc_attr( spine_get_option( 'contact_email' ) ); ?>"><?php echo esc_attr( spine_get_option( 'contact_email' ) ); ?></a>
	
	<?php
		$contact_point = spine_get_option( 'contact_ContactPoint' );
		if ( ! empty( $contact_point ) ) {
			?><meta itemprop="ContactPoint" title="<?php echo esc_attr( spine_get_option( 'contact_ContactPointTitle' ) ); ?>" content="<?php echo esc_attr( $contact_point ); ?>">
			<?php
		}
	?> 
</address>
</footer>