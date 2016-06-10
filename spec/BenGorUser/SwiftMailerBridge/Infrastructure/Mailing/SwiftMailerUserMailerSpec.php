<?php

/*
 * This file is part of the BenGorUser package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\BenGorUser\SwiftMailerBridge\Infrastructure\Mailing;

use BenGorUser\SwiftMailerBridge\Infrastructure\Mailing\SwiftMailerUserMailer;
use BenGorUser\User\Domain\Model\UserEmail;
use BenGorUser\User\Domain\Model\UserMailable;
use BenGorUser\User\Domain\Model\UserMailer;
use PhpSpec\ObjectBehavior;

/**
 * Spec file of SwiftMailerUserMailer class.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 */
class SwiftMailerUserMailerSpec extends ObjectBehavior
{
    function let(\Swift_Mailer $mailer)
    {
        $this->beConstructedWith($mailer);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(SwiftMailerUserMailer::class);
    }

    function it_implements_user_mailer()
    {
        $this->shouldImplement(UserMailer::class);
    }

    function it_mails(UserMailable $mail)
    {
        $to = new UserEmail('bengor@user.com');

        $mail->to()->shouldBeCalled()->willReturn($to);
        $mail->subject()->shouldBeCalled()->willReturn('Dummy subject');
        $mail->from()->shouldBeCalled()->willReturn(new UserEmail('bengor@user.com'));
        $mail->bodyText()->shouldBeCalled()->willReturn('The email body');
        $mail->bodyHtml()->shouldBeCalled()->willReturn('<html>The email body</html>');

        $this->mail($mail);
    }

    function it_mails_with_multiples_receivers(UserMailable $mail)
    {
        $to = [
            new UserEmail('bengor@user.com'),
            new UserEmail('gorka.lauzirika@gmail.com'),
            new UserEmail('benatespina@gmail.com'),
        ];

        $mail->to()->shouldBeCalled()->willReturn($to);
        $mail->subject()->shouldBeCalled()->willReturn('Dummy subject');
        $mail->from()->shouldBeCalled()->willReturn(new UserEmail('bengor@user.com'));
        $mail->bodyText()->shouldBeCalled()->willReturn('The email body');
        $mail->bodyHtml()->shouldBeCalled()->willReturn('<html>The email body</html>');

        $this->mail($mail);
    }
}
