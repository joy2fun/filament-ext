<x-dynamic-component
	:component="$getFieldWrapperView()"
	:field="$field">
	<div
		x-data="{
			mobile: $wire.$entangle('data.{{ $mobile_field ?? 'mobile' }}'),
			count: 0,
			get label() {
				return this.count > 0 ? `${this.count} 秒后可再次发送` : '发送验证码';
			},
			countDown() {
				if (String(this.mobile).length < 11) {
					new FilamentNotification().title('无效的手机号').warning().send()
					return;
				}
				if (this.count > 0) return;
				this.count = 60;
				$wire.sendSmsCode(this.mobile || '');
				let timer = setInterval(() => (--this.count <= 0) && clearInterval(timer), 1000)
			}
		}"
		@sms-code-reset-count.window="count=$event.detail.count"
		@sms-code-sent.window="new FilamentNotification().title('已发送').success().send()"
		@sms-code-sent-failed.window="count=0;new FilamentNotification().title('发送失败').body($event.detail.message).danger().send()"
		>
		<x-filament::input type="hidden" x-model="mobile" />
		<div class="">
			@if ($suffix_button ?? false)
			<x-filament::input.wrapper>
				<x-filament::input type="text" wire:model="{{ $getStatePath() }}" placeholder="输入手机验证码" />
				<x-slot name="suffix">
					<button type="button" :disabled="count > 0" x-text="label" @click.throttle.1000ms="countDown"></button>
				</x-slot>
			</x-filament::input.wrapper>
			@else
			<div class="flex flex-wrap gap-2">
				<x-filament::input.wrapper>
					<x-filament::input type="text" wire:model="{{ $getStatePath() }}" placeholder="输入手机验证码" />
				</x-filament::input.wrapper>
				<x-filament::button color="gray" x-bind:class="{'opacity-50': count > 0}" @click.throttle.1000ms="countDown" x-text="label" />
			</div>
			@endif
		</div>
	</div>
</x-dynamic-component>
