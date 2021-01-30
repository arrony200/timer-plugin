<?php
use Elementor\Utils;
use Elementor\Controls_Manager;
use Elementor\Widget_Base;
use Elementor\Plugin;
use Elementor\Group_Control_Typography;

class Themepuller_Pomodoro_Timer extends Widget_Base {


	public function get_name() {
		return 'pomodoro_timer';
	}

	public function get_title() {
		return esc_html__( 'Pomodoro Timer', 'themepuller' );
	}

	public function get_icon() {
		return 'eicon-post';
	}

	public function get_categories() {
		return array( 'basic' );
	}


	protected function _register_controls() {
		$this->start_controls_section(
			'section_content',
			array(
				'label' => esc_html__( 'Content', 'themepuller' ),
			)
		);
		$this->start_controls_tabs(
			'style_tabs'
		);
		$this->start_controls_tab(
			'pomodoro_tab',
			[
				'label' => __( 'Pomodoro', 'plugin-name' ),
			]
		);
		$this->add_control(
			'pomodoro_minutes',
			array(
				'label'   => esc_html__( 'Minutes', 'themepuller' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 5,
			)
		);
		$this->add_control(
			'pomodoro_seconds',
			array(
				'label'   => esc_html__( 'Seconds', 'themepuller' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 0,
			)
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			'short_break_tab',
			[
				'label' => __( 'Short Break', 'plugin-name' ),
			]
		);
		$this->add_control(
			'short_break_minutes',
			array(
				'label'   => esc_html__( 'Minutes', 'themepuller' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 15,
			)
		);
		$this->add_control(
			'short_break_seconds',
			array(
				'label'   => esc_html__( 'Seconds', 'themepuller' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 0,
			)
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			'long_break_tab',
			[
				'label' => __( 'Long Break', 'plugin-name' ),
			]
		);
		$this->add_control(
			'long_break_minutes',
			array(
				'label'   => esc_html__( 'Minutes', 'themepuller' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 10,
			)
		);
		$this->add_control(
			'long_break_seconds',
			array(
				'label'   => esc_html__( 'Seconds', 'themepuller' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 0,
			)
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();
		$this->start_controls_section(
			'section_style',
			array(
				'label' => __( 'Style', 'elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);
        $this->add_control(
			'pomodoro_color',
			[
			  'label' => __( 'Pomodoro Color', 'themepuler' ),
			  'type' => Controls_Manager::COLOR,
			  'selectors' => [
				'{{WRAPPER}} .pomodoro_timer' => 'background: {{VALUE}}',
				'{{WRAPPER}} .pomodoro_timer .btn-lg' => 'color: {{VALUE}}',
			  ],
			]
		  );
		  $this->add_control(
			'short_break_color',
			[
			  'label' => __( 'Short Break Color', 'themepuler' ),
			  'type' => Controls_Manager::COLOR,
			  'selectors' => [
				'{{WRAPPER}} .pomodoro_timer.shortbreak' => 'background: {{VALUE}}',
				'{{WRAPPER}} .pomodoro_timer.shortbreak .btn-lg' => 'color: {{VALUE}}',
			  ],
			]
		  );
		  $this->add_control(
			'longbreak_color',
			[
			  'label' => __( 'Longbreak Color', 'themepuler' ),
			  'type' => Controls_Manager::COLOR,
			  'selectors' => [
				'{{WRAPPER}} .pomodoro_timer.longbreak' => 'background: {{VALUE}}',
				'{{WRAPPER}} .pomodoro_timer.longbreak .btn-lg' => 'color: {{VALUE}}',
			  ],
			]
		  );
		  $this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'time_typography',
				'label'    => __( 'Time Typography', 'elementor' ),
				'selector' => '{{WRAPPER}} .pomodoro_timer .btn.btn-default',
				'selector' => '{{WRAPPER}} .timer-time',
			)
		);
		$this->end_controls_section();
	}

	protected function render() {
		$settings       = $this->get_settings();


		$pomodoro_minutes = $settings['pomodoro_minutes'];
		$pomodoro_seconds = $settings['pomodoro_seconds'];



		$short_break_minutes = $settings['short_break_minutes'];
		$short_break_seconds = $settings['short_break_seconds'];


		$long_break_minutes = $settings['long_break_minutes'];
		$long_break_seconds = $settings['long_break_seconds'];

		wp_localize_script( 
			'pomodoro-timer', 'time_object',
			array( 
				'ajax_url' => admin_url( 'admin-ajax.php' ),
				'pomodoro_minutes'=> $pomodoro_minutes,
				'pomodoro_seconds'=> $pomodoro_seconds,
				'short_break_minutes'=> $short_break_minutes,
				'short_break_seconds'=> $short_break_seconds,
				'long_break_minutes'=> $long_break_minutes,
				'long_break_seconds'=> $long_break_seconds,
			)
		);

		?>
  <div class="pomodoro_timer">
    <div class="page-header">
      <h1 class="text-center">Pomodoro Timer</h1>
      <h2 class="text-center">
        <span>
          <button id="pomodoroButton" class="btn btn-default" type="submit">Pomodoro</button>
          <button id="shortButton" class="btn btn-default" type="submit">Kurze Pause</button>
          <button id="longButton" class="btn btn-default" type="submit" id="onLongTimer">Lange Pause</button>
        </span>
      </h2>
    </div>
    <div class="panel panel-default">
      <div class="panel-body text-center">
        <div class="timer-time timer-container">
          <div class="timer-time-set timer-box" id="currentTime">
           <span id="minutesValue">00</span><span>:</span><span id="secondsValue">00</span>
          </div>
          <div class="timer-time-set timer-box" id="nextTime">
            <span id="minutesNext">00</span><span>:</span><span id="secondsNext">00</span>
          </div>
        </div>
        <div>
          <button id="startButton" class="btn btn-primary btn-lg" type="submit">
            <span class="glyphicon glyphicon-play" aria-hidden="true"></span> Start
          </button>
          <button id="stopButton" class="btn btn-danger btn-lg" type="submit">
            <span class="glyphicon glyphicon-stop" aria-hidden="true"></span> Halt
          </button>
		  <p class="pomodoro-text">Zeit zu lernen</p>
		  <p class="break-text">Zeit für eine Pause</p>
        </div>
      </div>
    </div>
  </div>
		<?php
	}

	protected function content_template() {
	}
}

Plugin::instance()->widgets_manager->register_widget_type( new Themepuller_Pomodoro_Timer() );