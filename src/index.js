import { registerBlockType } from '@wordpress/blocks';
import './EmployeeBlock/style.scss';
import Edit from './EmployeeBlock/edit';

registerBlockType( 'inpsyde/employee-block', {
	title: 'Employee Block',
	edit: props => Edit(props),
} );
