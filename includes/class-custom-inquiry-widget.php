<?php
add_action( 'widgets_init', function(){
    register_widget( 'Custom_Inquiry' );
});

class Custom_Inquiry extends WP_Widget {

    /**
     * Sets up the widgets name etc
     */
    public function __construct() {
        $widget_ops = array(
            'classname' => 'az_custom_inquiry',
            'description' => 'This is Custom Inquiry widget with option page having lists of inquiry.',
        );

        parent::__construct( 'az_custom_inquiry', 'Custom Inquiry', $widget_ops );
    }


    /**
     * Outputs the content of the widget
     *
     * @param array $args
     * @param array $instance
     */
    public function widget( $args, $instance ) {
        // outputs the content of the widget
        $widget_id = $args['id'];
        echo $args['before_widget'];
        ?>
        <div class="container form_design">  
		  <form  method="post" class="custom_inquiry_az" id="<?php echo $widget_id; ?>" >
		    <?php if(!empty($instance['title'])) {?>
		    	<h3><?php echo $instance['title']; ?></h3>
		    <?php } ?>
            <div class="form_padding">
		    <?php if(!empty($instance['subtitle'])) {?>
		    	<h4><?php echo $instance['subtitle']; ?></h4>
		    <?php } ?>
		    <fieldset>
		      <input placeholder="Your name" type="text" tabindex="1" required autofocus name="name">
		    </fieldset>
		    <fieldset>
		      <input placeholder="Your Subject" type="text" required name="subject">
		    </fieldset>
		    <fieldset>
		      <input placeholder="Your Email Address" type="email" tabindex="2" required name="email">
		    </fieldset>
		    <fieldset>
		      <input placeholder="Your Phone Number" type="tel" required name="phone">
		    </fieldset>
		    <fieldset>
		      <input placeholder="Your Web Site starts with http://" type="url" name="website">
		    </fieldset>
		    <fieldset>
		      <textarea placeholder="Type your Message Here...." tabindex="5" required name="message"></textarea>
		    </fieldset>
		    <fieldset>
		    <div class="image_loader" style="display: none;"><img src="<?php echo plugins_url( '/public/img/Spinner.gif', dirname(__FILE__) ); ?>"></div>
		      <button name="submit" type="submit" id="contact-submit" data-submit="...Sending">Submit</button>
		    </fieldset>
            <div class="alert fade in" style="margin-top:18px;display: none;" id="status_msg"></div>
            </div>
		  </form>
		</div>
        <?php echo $args['after_widget'];
    }


    /**
     * Outputs the options form on admin
     *
     * @param array $instance The widget options
     */
    public function form( $instance ) {
        // outputs the options form on admin
        $title = ! empty( $instance['title'] ) ? $instance['title'] : __( 'New title', 'text_domain' );
        $subtitle = ! empty( $instance['subtitle'] ) ? $instance['subtitle'] : __( 'New Sub title', 'text_domain' );
        ?>
            <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
            </p>
            <p>
            <label for="<?php echo $this->get_field_id( 'subtitle' ); ?>"><?php _e( 'Sub title:' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'subtitle' ); ?>" name="<?php echo $this->get_field_name( 'subtitle' ); ?>" type="text" value="<?php echo esc_attr( $subtitle ); ?>">
            </p>
        <?php
    }


    /**
     * Processing widget options on save
     *
     * @param array $new_instance The new options
     * @param array $old_instance The previous options
     */
    public function update( $new_instance, $old_instance ) {
        // processes widget options to be saved
        foreach( $new_instance as $key => $value )
        {
            $updated_instance[$key] = sanitize_text_field($value);
        }

        return $updated_instance;
    }
}