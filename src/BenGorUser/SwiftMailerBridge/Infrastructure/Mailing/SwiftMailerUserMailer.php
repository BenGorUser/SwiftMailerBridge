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

namespace BenGorUser\SwiftMailerBridge\Infrastructure\Mailing;

use BenGorUser\User\Domain\Model\UserEmail;
use BenGorUser\User\Domain\Model\UserMailable;
use BenGorUser\User\Domain\Model\UserMailer;

/**
 * SwiftMailer user mailer class.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 * @author Gorka Laucirica <gorka.lauzirika@gmail.com>
 */
final class SwiftMailerUserMailer implements UserMailer
{
    /**
     * The swift mailer instance.
     *
     * @var \Swift_Mailer
     */
    private $swiftMailer;

    /**
     * Constructor.
     *
     * @param \Swift_Mailer $swiftMailer The swift mailer instance
     */
    public function __construct(\Swift_Mailer $swiftMailer)
    {
        $this->swiftMailer = $swiftMailer;
    }

    /**
     * {@inheritdoc}
     */
    public function mail(UserMailable $mail)
    {
        if (is_array($mail->to())) {
            $to = array_map(function (UserEmail $receiver) {
                return $receiver->email();
            }, $mail->to());
        } else {
            $to = $mail->to()->email();
        }

        $message = \Swift_Message::newInstance()
            ->setSubject($mail->subject())
            ->setFrom($mail->from()->email())
            ->setTo($to)
            ->setBody($mail->bodyText(), 'text/plain')
            ->addPart($mail->bodyHtml(), 'text/html');

        $this->swiftMailer->send($message);
    }
}
