pipeline {
  agent any
  stages {
    stage('Stage') {
      steps {
        input(message: 'Deploy To Stage?', id: 'deploy_to_stage_id', ok: 'ok_parameter', submitter: 'antun', submitterParameter: 'antunParameter')
      }
    }

    stage('Production') {
      steps {
        input(message: 'Deploy To Production?', id: 'deploy_to_production_id', ok: 'deploy_to_production_id_ok_param', submitter: 'antun_prooduction_submitter', submitterParameter: 'antun_prooduction_submitter_parameter')
      }
    }

  }
}