import os
import subprocess

from aws_cdk import (
    Duration,
    Stack,
    aws_events as events,
    aws_events_targets as event_targets,
    aws_lambda as lambda_,
    aws_dynamodb as dynamodb,
    aws_iam as iam
)

from constructs import Construct

class CdvStack(Stack):

    def __init__(self, scope: Construct, construct_id: str, **kwargs) -> None:
        super().__init__(scope, construct_id, **kwargs)

        table = dynamodb.Table(
            self, 'PullRequests',
            partition_key=dynamodb.Attribute(
                name='timestamp',
                type=dynamodb.AttributeType.STRING
            )
        )

        cdv_lambda = lambda_.Function(
            self,
            'CdvLambda',
            code=lambda_.Code.from_asset('code'),
            handler='lambda.lambda_handler',
            runtime=lambda_.Runtime.PYTHON_3_9,
            memory_size=256,
            timeout=Duration.seconds(30),
            layers=[
                self.create_dependencies_layer(
                    'CdvLambda',
                    'code'
                )
            ],
            environment={
                'TABLE_NAME': table.table_name
            }
        )

        table.grant_full_access(cdv_lambda)

        event_rule = events.Rule(
            self,
            'CdvEventRule',
            schedule=events.Schedule.cron(
                minute='0',
                hour='*',
                day='*',
                month='*'
            )
        )

        event_rule.add_target(
            event_targets.LambdaFunction(cdv_lambda)
        )



    def create_dependencies_layer(self, function_name: str, requirements_path: str) -> lambda_.LayerVersion:
        requirements_file = f'{requirements_path}/requirements.txt'
        output_dir = f'.lambda_dependencies/{function_name}'
        if not os.environ.get('SKIP_PIP'):
            subprocess.check_call(
                f'pip install -r {requirements_file} -t {output_dir}/python'.split()
            )

        return lambda_.LayerVersion(
            self,
            f'{function_name}-dependencies',
            code=lambda_.Code.from_asset(output_dir)
        )
